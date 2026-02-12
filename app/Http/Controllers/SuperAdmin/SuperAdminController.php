<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Gym;
use App\Models\Member;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class SuperAdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_gyms' => Gym::count(),
            'active_gyms' => Gym::where('is_active', true)->count(),
            'expired_gyms' => Gym::where('subscription_expires_at', '<', now())->count(),
            'total_members' => Member::count(),
            'total_users' => User::count(),
            'total_subscriptions' => Subscription::count(),
        ];

        $gyms = Gym::withCount(['users', 'members', 'subscriptions'])
            ->latest()
            ->get();

        return view('super_admin.dashboard', compact('gyms', 'stats'));
    }

    public function createGym()
    {
        return view('super_admin.gyms.create');
    }

    public function storeGym(Request $request)
    {
        $request->validate([
            'gym_name' => ['required', 'string', 'max:255'],
            'admin_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email'],
            'admin_password' => ['required', 'confirmed', Rules\Password::defaults()],
            'subscription_months' => ['required', 'integer', 'min:1', 'max:36'],
        ]);

        // Create Gym
        $gym = Gym::create([
            'name' => $request->gym_name,
            'subscription_expires_at' => now()->addMonths((int)$request->subscription_months),
            'is_active' => true,
        ]);

        // Create Gym Admin
        $user = User::create([
            'name' => $request->admin_name,
            'email' => $request->admin_email,
            'password' => Hash::make($request->admin_password),
            'role' => 'gym_admin',
            'gym_id' => $gym->id,
        ]);

        return redirect()->route('super_admin.dashboard')
            ->with('success', 'تم إنشاء الصالة وحساب المدير بنجاح!');
    }

    public function editGym(Gym $gym)
    {
        return view('super_admin.gyms.edit', compact('gym'));
    }

    public function updateGym(Request $request, Gym $gym)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'subscription_expires_at' => ['required', 'date'],
            'is_active' => ['required', 'boolean'],
        ]);

        $gym->update($request->all());

        return redirect()->route('super_admin.dashboard')
            ->with('success', 'تم تحديث بيانات الصالة بنجاح!');
    }

    public function toggleGymStatus(Gym $gym)
    {
        $gym->update(['is_active' => !$gym->is_active]);

        return redirect()->route('super_admin.dashboard')
            ->with('success', 'تم تغيير حالة الصالة بنجاح!');
    }

    public function extendSubscription(Request $request, Gym $gym)
    {
        $request->validate([
            'months' => ['required', 'integer', 'min:1', 'max:12'],
        ]);

        $months = (int)$request->months;

        $newExpiryDate = $gym->subscription_expires_at > now()
            ? $gym->subscription_expires_at->copy()->addMonths($months)
            : now()->addMonths($months);

        $gym->update(['subscription_expires_at' => $newExpiryDate]);

        return redirect()->route('super_admin.dashboard')
            ->with('success', 'تم تمديد الاشتراك بنجاح!');
    }

    public function showGymDetails(Gym $gym)
    {
        $gym->load(['users', 'members', 'subscriptions.member', 'subscriptions.plan']);

        return view('super_admin.gyms.show', compact('gym'));
    }

    public function indexGyms(Request $request)
    {
        $query = Gym::withCount(['users', 'members', 'subscriptions']);

        // Filter by Status (Active/Inactive)
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by Trashed
        if ($request->filled('trashed')) {
            if ($request->trashed === 'only') {
                $query->onlyTrashed();
            } elseif ($request->trashed === 'with') {
                $query->withTrashed();
            }
        }

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $gyms = $query->latest()->paginate(10);

        return view('super_admin.gyms.index', compact('gyms'));
    }

    public function destroyGym(Gym $gym)
    {
        // Soft delete logic is handled by the model trait
        $gym->delete();

        return redirect()->route('super_admin.gyms.index')
            ->with('success', 'تم حذف الصالة بنجاح (نقلت إلى سلة المحذوفات).');
    }

    public function restoreGym($id)
    {
        $gym = Gym::onlyTrashed()->findOrFail($id);
        $gym->restore();

        return redirect()->route('super_admin.gyms.index')
            ->with('success', 'تم استعادة الصالة بنجاح.');
    }

    public function bulkDestroyGym(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:gyms,id',
        ]);

        Gym::whereIn('id', $request->ids)->delete();

        return redirect()->route('super_admin.gyms.index')
            ->with('success', 'تم حذف الصالات المحددة بنجاح.');
    }

    public function indexUsers()
    {
        $users = User::with('gym')
            ->latest()
            ->paginate(20);

        return view('super_admin.users.index', compact('users'));
    }

    public function indexReports()
    {
        return view('super_admin.reports.index');
    }
}
