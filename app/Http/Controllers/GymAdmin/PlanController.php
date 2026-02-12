<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\TrainingType;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $gym = auth()->user()->gym;
        $trainingTypes = $gym->trainingTypes;
        $selectedTrainingTypeId = $request->training_type_id;

        return view('gym_admin.plans.create', compact('trainingTypes', 'selectedTrainingTypeId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $gym = auth()->user()->gym;

        $validated = $request->validate([
            'training_type_id' => 'required|exists:training_types,id',
            'name' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        // Verify training type belongs to gym
        $trainingType = $gym->trainingTypes()->findOrFail($validated['training_type_id']);

        Plan::create([
            'gym_id' => $gym->id,
            'training_type_id' => $trainingType->id,
            'name' => $validated['name'],
            'duration_days' => $validated['duration_days'],
            'price' => $validated['price'],
            'is_active' => true,
        ]);

        return redirect()->route('gym.training-types.show', $trainingType)->with('success', 'تم إضافة خطة الاشتراك بنجاح.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        $this->authorizePlan($plan);
        return view('gym_admin.plans.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        $this->authorizePlan($plan);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $plan->update($validated);

        return redirect()->route('gym.training-types.show', $plan->training_type_id)->with('success', 'تم تحديث خطة الاشتراك بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        $this->authorizePlan($plan);
        $trainingTypeId = $plan->training_type_id;
        $plan->delete();

        return redirect()->route('gym.training-types.show', $trainingTypeId)->with('success', 'تم حذف خطة الاشتراك بنجاح.');
    }

    private function authorizePlan(Plan $plan)
    {
        if ($plan->gym_id !== auth()->user()->gym_id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
