<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::withCount(['borrows as active_borrows_count' => fn ($query) => $query->where('status', 'borrowed')])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('full_name', 'like', "%{$search}%")
                        ->orWhere('registration_number', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('department', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create', ['student' => null]);
    }

    public function store(Request $request)
    {
        Student::create($this->validated($request));

        return redirect()->route('students.index')->with('success', 'Customer registered successfully.');
    }

    public function show(Student $student)
    {
        $student->load(['borrows.book', 'lostBooks.book']);

        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $student->update($this->validated($request, $student->id));

        return redirect()->route('students.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Student $student)
    {
        if ($student->borrows()->whereIn('status', ['borrowed', 'pending'])->exists()) {
            return back()->with('error', 'This customer has active borrowings.');
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Customer deleted successfully.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'registration_number' => ['required', 'string', 'max:100', 'unique:students,registration_number,'.$id],
            'email' => ['required', 'email', 'max:255', 'unique:students,email,'.$id],
            'phone' => ['nullable', 'string', 'max:50'],
            'department' => ['required', 'string', 'max:255'],
        ]);
    }
}
