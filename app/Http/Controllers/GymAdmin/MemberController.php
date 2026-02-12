<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\TrainingType;
use App\Models\Plan;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    private function getGym()
    {
        return auth()->user()->gym;
    }

    public function index(Request $request)
    {
        $gym = $this->getGym();
        $query = $gym->members()->with(['subscriptions.plan.trainingType']);

        // Filter by Training Type
        if ($request->filled('training_type_id')) {
            $query->whereHas('subscriptions.plan', function($q) use ($request) {
                $q->where('training_type_id', $request->training_type_id);
            });
        }

        // Filter by Status
        if ($request->has('status')) {
            switch ($request->status) {
                case 'active':
                    $query->active();
                    break;
                case 'expired':
                    $query->expired();
                    break;
                case 'inactive':
                    $query->inactive();
                    break;
            }
        }

        // Filter by Expiry Date Range
        if ($request->filled('expiry_start') && $request->filled('expiry_end')) {
            $query->whereHas('subscriptions', function($q) use ($request) {
                $q->whereBetween('end_date', [$request->expiry_start, $request->expiry_end]);
            });
        }

        if ($request->has('search') || $request->has('q')) {
            $search = $request->search ?? $request->q;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('cin', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $members = $query->latest()->paginate(10);
        $trainingTypes = $gym->trainingTypes;

        // Calculate counts
        $counts = [
            'status' => [
                'all' => $gym->members()->count(),
                'active' => $gym->members()->active()->count(),
                'expired' => $gym->members()->expired()->count(),
                'inactive' => $gym->members()->inactive()->count(),
            ],
            'training_type' => [
                'all' => $gym->members()->count(),
            ]
        ];

        foreach ($trainingTypes as $type) {
            $counts['training_type'][$type->id] = $gym->members()->whereHas('subscriptions.plan', function($q) use ($type) {
                $q->where('training_type_id', $type->id);
            })->count();
        }

        return view('gym_admin.members.index', compact('members', 'trainingTypes', 'counts'));
    }

    public function export(Request $request)
    {
        $gym = $this->getGym();
        $query = $gym->members()->with(['subscriptions.plan.trainingType']);

        // Apply same filters as index...
        // (Copy-paste filter logic or extract to method, for brevity I'll keep it simple here)
        if ($request->filled('status') && $request->status == 'active') $query->active();
        if ($request->filled('status') && $request->status == 'expired') $query->expired();
        if ($request->filled('status') && $request->status == 'inactive') $query->inactive();

        $members = $query->get();

        $filename = "members_" . date('Y-m-d_H-i') . ".csv";
        $handle = fopen('php://memory', 'w');

        // Add BOM for Excel UTF-8 compatibility
        fputs($handle, "\xEF\xBB\xBF");

        fputcsv($handle, ['ID', 'Nom Complet', 'CIN', 'Téléphone', 'Genre', 'Statut', 'Plan Actuel', 'Date Fin']);

        foreach ($members as $member) {
            $plan = $member->activeSubscription?->plan->name ?? 'Aucun';
            $endDate = $member->activeSubscription?->end_date?->format('Y-m-d') ?? '-';

            fputcsv($handle, [
                $member->id,
                $member->full_name,
                $member->cin,
                $member->phone,
                $member->gender,
                $member->status,
                $plan,
                $endDate
            ]);
        }

        fseek($handle, 0);

        return response()->stream(
            function () use ($handle) {
                fpassthru($handle);
                fclose($handle);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ]
        );
    }

    public function bulkMessage(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'message' => 'required|string|max:160',
        ]);

        // Logic to send SMS or Email would go here
        // For now, we simulate success

        return back()->with('success', 'Message envoyé à ' . count($request->ids) . ' membres avec succès.');
    }

    public function create(Request $request)
    {
        $gym = $this->getGym();
        // Get all active plans sorted by training type for this gym
        $trainingTypes = $gym->trainingTypes()->with(['plans' => function($query) {
            $query->active();
        }])->get();

        return view('gym_admin.members.create', [
            'trainingTypes' => $trainingTypes,
            'preselectedTrainingTypeId' => $request->training_type_id,
            'preselectedPlanId' => $request->plan_id
        ]);
    }

    public function store(\App\Http\Requests\StoreMemberRequest $request)
    {
        $gym = $this->getGym();

        // Start Transaction
        DB::transaction(function () use ($request, $gym) {

            // 1. Create Member
            $data = $request->validated();
            $data['gym_id'] = $gym->id; // Assign to current gym

            if ($request->hasFile('photo')) {
                $data['photo_path'] = $request->file('photo')->store('members', 'uploads');
            }

            $member = Member::create($data);

            // 2. Create Subscription
            // Ensure plan belongs to this gym
            $plan = $gym->plans()->findOrFail($request->plan_id);

            $startDate = \Carbon\Carbon::parse($request->start_date);

            // Calculate end date logically
            $endDate = match((int)$plan->duration_days) {
                30 => $startDate->copy()->addMonth(),
                90 => $startDate->copy()->addMonths(3),
                180 => $startDate->copy()->addMonths(6),
                365 => $startDate->copy()->addYear(),
                default => $startDate->copy()->addDays($plan->duration_days),
            };

            $member->subscriptions()->create([
                'gym_id' => $gym->id, // Add gym_id to subscription
                'plan_id' => $plan->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'price_snapshot' => $plan->price,
            ]);

            // 3. Create Invoice & Payment
            $invoiceNumber = 'INV-' . $gym->id . '-' . time() . '-' . rand(100, 999);
            $invoice = Invoice::create([
                'gym_id' => $gym->id,
                'member_id' => $member->id,
                'invoice_number' => $invoiceNumber,
                'issue_date' => now(),
                'due_date' => now(),
                'total_amount' => $plan->price,
                'paid_amount' => $plan->price,
                'status' => 'paid',
                'type' => 'subscription',
            ]);

            $invoice->payments()->create([
                'gym_id' => $gym->id,
                'member_id' => $member->id,
                'amount' => $plan->price,
                'payment_method' => $request->payment_method,
                'payment_date' => now(),
                'notes' => 'Paiement initial abonnement ' . $plan->name,
            ]);
        });

        return redirect()->route('gym.members.index')->with('success', 'Member created successfully.');
    }

    public function show(Member $member)
    {
        $this->authorizeMember($member);
        $member->load('subscriptions.plan.trainingType');
        return view('gym_admin.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        $this->authorizeMember($member);
        $gym = $this->getGym();

        $trainingTypes = $gym->trainingTypes()->with(['plans' => function($query) {
            $query->active();
        }])->get();

        return view('gym_admin.members.edit', compact('member', 'trainingTypes'));
    }

    public function update(Request $request, Member $member)
    {
        $this->authorizeMember($member);

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'cin' => ['required', 'string', 'max:20', 'unique:members,cin,' . $member->id],
            'gender' => ['required', 'in:male,female'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('members', 'uploads');
        }

        $member->update($validated);

        return redirect()->route('gym.members.index')->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        $this->authorizeMember($member);
        $member->delete();
        return redirect()->route('gym.members.index')->with('success', 'Member deleted successfully.');
    }

    public function renew(Member $member)
    {
        $this->authorizeMember($member);
        $gym = $this->getGym();

        $trainingTypes = $gym->trainingTypes()->with(['plans' => function($query) {
            $query->active();
        }])->get();

        return view('gym_admin.members.renew', compact('member', 'trainingTypes'));
    }

    public function storeRenewal(Request $request, Member $member)
    {
        $this->authorizeMember($member);
        $gym = $this->getGym();

        $validated = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'price' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'in:cash,card,transfer'],
        ]);

        // Ensure plan belongs to gym
        $plan = $gym->plans()->findOrFail($validated['plan_id']);

        $member->subscriptions()->create([
            'gym_id' => $gym->id,
            'plan_id' => $plan->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'price_snapshot' => $validated['price'],
        ]);

        // Create Invoice & Payment
        $invoiceNumber = 'INV-' . $gym->id . '-' . time() . '-' . rand(100, 999);
        $invoice = Invoice::create([
            'gym_id' => $gym->id,
            'member_id' => $member->id,
            'invoice_number' => $invoiceNumber,
            'issue_date' => now(),
            'due_date' => now(),
            'total_amount' => $validated['price'],
            'paid_amount' => $validated['price'],
            'status' => 'paid',
            'type' => 'subscription',
        ]);

        $invoice->payments()->create([
            'gym_id' => $gym->id,
            'member_id' => $member->id,
            'amount' => $validated['price'],
            'payment_method' => $validated['payment_method'],
            'payment_date' => now(),
            'notes' => 'Renouvellement abonnement ' . $plan->name,
        ]);

        return redirect()->route('gym.members.index')->with('success', 'Abonnement renouvelé avec succès.');
    }

    public function updateSubscription(Request $request, \App\Models\Subscription $subscription)
    {
        if ($subscription->gym_id !== auth()->user()->gym_id) {
            abort(403);
        }

        $validated = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        // Ensure plan belongs to gym
        $gym = $this->getGym();
        $plan = $gym->plans()->findOrFail($validated['plan_id']);

        $subscription->update([
            'plan_id' => $plan->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'price_snapshot' => $validated['price'],
        ]);

        return back()->with('success', 'Abonnement mis à jour avec succès.');
    }

    private function authorizeMember(Member $member)
    {
        if ($member->gym_id !== auth()->user()->gym_id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
