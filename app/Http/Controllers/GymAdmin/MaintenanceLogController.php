<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\MaintenanceLog;
use Illuminate\Http\Request;

class MaintenanceLogController extends Controller
{
    private function getGym()
    {
        return auth()->user()->gym;
    }

    public function store(Request $request, Equipment $equipment)
    {
        if ($equipment->gym_id !== $this->getGym()->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'maintenance_date' => 'required|date',
            'next_maintenance_date' => 'nullable|date|after:maintenance_date',
            'cost' => 'required|numeric|min:0',
            'status' => 'required|string',
            'performed_by' => 'nullable|string|max:255',
        ]);

        $equipment->maintenanceLogs()->create([
            'gym_id' => $this->getGym()->id,
            'title' => $request->title,
            'description' => $request->description,
            'maintenance_date' => $request->maintenance_date,
            'next_maintenance_date' => $request->next_maintenance_date,
            'cost' => $request->cost,
            'status' => $request->status,
            'performed_by' => $request->performed_by,
        ]);

        // Auto-update equipment status if maintenance is in progress or completed
        if ($request->status === 'in_progress') {
            $equipment->update(['status' => 'maintenance']);
        } elseif ($request->status === 'completed' && $equipment->status === 'maintenance') {
            $equipment->update(['status' => 'active']);
        }

        return back()->with('success', 'Maintenance enregistrée avec succès.');
    }

    public function update(Request $request, MaintenanceLog $maintenanceLog)
    {
        if ($maintenanceLog->gym_id !== $this->getGym()->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'maintenance_date' => 'required|date',
            'cost' => 'required|numeric|min:0',
            'status' => 'required|string',
        ]);

        $maintenanceLog->update($request->all());

        return back()->with('success', 'Maintenance mise à jour.');
    }

    public function destroy(MaintenanceLog $maintenanceLog)
    {
        if ($maintenanceLog->gym_id !== $this->getGym()->id) {
            abort(403);
        }

        $maintenanceLog->delete();

        return back()->with('success', 'Maintenance supprimée.');
    }
}
