<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainerController extends Controller
{
    private function getGym()
    {
        return auth()->user()->gym;
    }

    public function index()
    {
        $trainers = $this->getGym()->trainers()->latest()->paginate(10);
        return view('gym_admin.trainers.index', compact('trainers'));
    }

    public function create()
    {
        return view('gym_admin.trainers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('photo');
        $data['gym_id'] = $this->getGym()->id;

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('trainers', 'uploads');
        }

        Trainer::create($data);

        return redirect()->route('gym.trainers.index')->with('success', 'Entraîneur ajouté avec succès.');
    }

    public function edit(Trainer $trainer)
    {
        if ($trainer->gym_id !== $this->getGym()->id) {
            abort(403);
        }
        return view('gym_admin.trainers.edit', compact('trainer'));
    }

    public function update(Request $request, Trainer $trainer)
    {
        if ($trainer->gym_id !== $this->getGym()->id) {
            abort(403);
        }

        $request->validate([
            'full_name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'photo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            if ($trainer->photo_path) {
                Storage::disk('uploads')->delete($trainer->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('trainers', 'uploads');
        }

        $trainer->update($data);

        return redirect()->route('gym.trainers.index')->with('success', 'Entraîneur mis à jour avec succès.');
    }

    public function destroy(Trainer $trainer)
    {
        if ($trainer->gym_id !== $this->getGym()->id) {
            abort(403);
        }

        if ($trainer->photo_path) {
            Storage::disk('uploads')->delete($trainer->photo_path);
        }

        $trainer->delete();

        return redirect()->route('gym.trainers.index')->with('success', 'Entraîneur supprimé avec succès.');
    }
}
