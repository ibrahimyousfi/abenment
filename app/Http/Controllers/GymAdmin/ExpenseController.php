<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    private function getGym()
    {
        return auth()->user()->gym;
    }

    public function index(Request $request)
    {
        $query = $this->getGym()->expenses()->latest('expense_date');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('expense_date', [$request->start_date, $request->end_date]);
        }

        $expenses = $query->paginate(10);

        return view('gym_admin.expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('gym_admin.expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'category' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $data = $request->except('attachment');
        $data['gym_id'] = $this->getGym()->id;

        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')->store('expenses', 'uploads');
        }

        Expense::create($data);

        return redirect()->route('gym.expenses.index')->with('success', 'Dépense enregistrée avec succès.');
    }

    public function edit(Expense $expense)
    {
        if ($expense->gym_id !== $this->getGym()->id) {
            abort(403);
        }
        return view('gym_admin.expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        if ($expense->gym_id !== $this->getGym()->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'category' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $data = $request->except('attachment');

        if ($request->hasFile('attachment')) {
            if ($expense->attachment_path) {
                Storage::disk('uploads')->delete($expense->attachment_path);
            }
            $data['attachment_path'] = $request->file('attachment')->store('expenses', 'uploads');
        }

        $expense->update($data);

        return redirect()->route('gym.expenses.index')->with('success', 'Dépense mise à jour avec succès.');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->gym_id !== $this->getGym()->id) {
            abort(403);
        }

        if ($expense->attachment_path) {
            Storage::disk('uploads')->delete($expense->attachment_path);
        }

        $expense->delete();

        return redirect()->route('gym.expenses.index')->with('success', 'Dépense supprimée avec succès.');
    }
}
