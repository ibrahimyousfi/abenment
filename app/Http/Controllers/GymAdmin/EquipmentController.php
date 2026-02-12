<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    private function getGym()
    {
        return auth()->user()->gym;
    }

    public function index(Request $request)
    {
        $query = $this->getGym()->equipment()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('brand', 'like', "%$search%")
                  ->orWhere('model', 'like', "%$search%");
            });
        }

        $equipment = $query->paginate(10);

        return view('gym_admin.equipment.index', compact('equipment'));
    }

    public function create()
    {
        return view('gym_admin.equipment.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'price' => 'nullable|numeric|min:0',
            'warranty_expiry' => 'nullable|date|after_or_equal:purchase_date',
            'photo' => 'nullable|image|max:2048',
            'status' => 'required|string',
        ]);

        $data = $request->except('photo');
        $data['gym_id'] = $this->getGym()->id;

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('equipment', 'uploads');
        }

        $equipment = Equipment::create($data);

        return redirect()->route('gym.equipment.show', $equipment)->with('success', 'Équipement ajouté avec succès.');
    }

    public function show(Equipment $equipment)
    {
        if ($equipment->gym_id !== $this->getGym()->id) {
            abort(403);
        }
        $equipment->load('maintenanceLogs');
        return view('gym_admin.equipment.show', compact('equipment'));
    }

    public function edit(Equipment $equipment)
    {
        if ($equipment->gym_id !== $this->getGym()->id) {
            abort(403);
        }
        return view('gym_admin.equipment.edit', compact('equipment'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        if ($equipment->gym_id !== $this->getGym()->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'price' => 'nullable|numeric|min:0',
            'warranty_expiry' => 'nullable|date|after_or_equal:purchase_date',
            'photo' => 'nullable|image|max:2048',
            'status' => 'required|string',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            if ($equipment->photo_path) {
                Storage::disk('uploads')->delete($equipment->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('equipment', 'uploads');
        }

        $equipment->update($data);

        return redirect()->route('gym.equipment.show', $equipment)->with('success', 'Équipement mis à jour avec succès.');
    }

    public function destroy(Equipment $equipment)
    {
        if ($equipment->gym_id !== $this->getGym()->id) {
            abort(403);
        }

        if ($equipment->photo_path) {
            Storage::disk('uploads')->delete($equipment->photo_path);
        }

        $equipment->delete();

        return redirect()->route('gym.equipment.index')->with('success', 'Équipement supprimé avec succès.');
    }
}
