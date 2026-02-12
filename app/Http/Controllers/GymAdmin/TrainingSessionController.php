<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Models\TrainingSession;
use App\Models\Trainer;
use App\Models\TrainingType;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Booking;
use App\Models\Member;
use App\Notifications\SessionSpotAvailable;

class TrainingSessionController extends Controller
{
    private function getGym()
    {
        return auth()->user()->gym;
    }

    // ... (existing methods)

    public function show(TrainingSession $session)
    {
        if ($session->gym_id !== $this->getGym()->id) {
            abort(403);
        }

        $session->load(['bookings.member', 'trainer', 'trainingType']);

        // Get active members not already booked
        $gym = $this->getGym();
        $bookedMemberIds = $session->bookings->pluck('member_id')->toArray();
        $members = $gym->members()->active()->whereNotIn('id', $bookedMemberIds)->get();

        return view('gym_admin.sessions.show', compact('session', 'members'));
    }

    public function addBooking(Request $request, TrainingSession $session)
    {
        if ($session->gym_id !== $this->getGym()->id) {
            abort(403);
        }

        $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        // Check capacity
        if ($session->is_full) {
            // Add to waiting list? For now just error or handle waiting status
             // If we want waiting list, we set status to 'waiting'
             $status = 'waiting';
             $message = 'Session complète. Membre ajouté à la liste d\'attente.';
        } else {
            $status = 'confirmed';
            $message = 'Membre inscrit avec succès.';
        }

        Booking::create([
            'gym_id' => $session->gym_id,
            'training_session_id' => $session->id,
            'member_id' => $request->member_id,
            'status' => $status,
        ]);

        return back()->with('success', $message);
    }

    public function removeBooking(Booking $booking)
    {
        if ($booking->gym_id !== $this->getGym()->id) {
            abort(403);
        }

        $booking->delete();

        // Check if we can promote someone from waiting list
        $session = $booking->session;
        if (!$session->is_full) {
            $nextWaiting = $session->bookings()->where('status', 'waiting')->orderBy('created_at')->first();
            if ($nextWaiting) {
                $nextWaiting->update(['status' => 'confirmed']);
                
                // Send notification if member has email
                if ($nextWaiting->member->email) {
                     $nextWaiting->member->notify(new SessionSpotAvailable($session));
                }
            }
        }

        return back()->with('success', 'Réservation annulée.');
    }

    public function index(Request $request)
    {
        $query = $this->getGym()->trainingSessions()->with(['trainer', 'trainingType', 'bookings']);

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('start_time', $request->date);
        } else {
            // Default to upcoming sessions
            $query->whereDate('start_time', '>=', now()->toDateString());
        }

        $sessions = $query->orderBy('start_time')->paginate(10);

        return view('gym_admin.sessions.index', compact('sessions'));
    }

    public function create()
    {
        $gym = $this->getGym();
        $trainers = $gym->trainers()->where('is_active', true)->get();
        $trainingTypes = $gym->trainingTypes;

        return view('gym_admin.sessions.create', compact('trainers', 'trainingTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'training_type_id' => 'required|exists:training_types,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'capacity' => 'required|integer|min:1',
        ]);

        $gym = $this->getGym();

        // Verify ownership
        if ($request->trainer_id && !$gym->trainers()->where('id', $request->trainer_id)->exists()) {
            abort(403, 'Invalid trainer.');
        }
        if (!$gym->trainingTypes()->where('id', $request->training_type_id)->exists()) {
            abort(403, 'Invalid training type.');
        }

        TrainingSession::create([
            'gym_id' => $gym->id,
            'training_type_id' => $request->training_type_id,
            'trainer_id' => $request->trainer_id,
            'name' => $request->name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'capacity' => $request->capacity,
            'status' => 'scheduled',
        ]);

        return redirect()->route('gym.sessions.index')->with('success', 'Séance planifiée avec succès.');
    }

    public function edit(TrainingSession $session)
    {
        if ($session->gym_id !== $this->getGym()->id) {
            abort(403);
        }

        $gym = $this->getGym();
        $trainers = $gym->trainers()->where('is_active', true)->get();
        $trainingTypes = $gym->trainingTypes;

        return view('gym_admin.sessions.edit', compact('session', 'trainers', 'trainingTypes'));
    }

    public function update(Request $request, TrainingSession $session)
    {
        if ($session->gym_id !== $this->getGym()->id) {
            abort(403);
        }

        $request->validate([
            'training_type_id' => 'required|exists:training_types,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:scheduled,cancelled,completed',
        ]);

        $session->update($request->all());

        return redirect()->route('gym.sessions.index')->with('success', 'Séance mise à jour avec succès.');
    }

    public function destroy(TrainingSession $session)
    {
        if ($session->gym_id !== $this->getGym()->id) {
            abort(403);
        }

        // Check if there are bookings
        if ($session->bookings()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer une séance avec des réservations. Veuillez d\'abord l\'annuler.');
        }

        $session->delete();

        return redirect()->route('gym.sessions.index')->with('success', 'Séance supprimée avec succès.');
    }
}
