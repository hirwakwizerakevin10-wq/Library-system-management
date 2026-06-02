<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\LostBook;
use App\Models\Student;

class ReportController extends Controller
{
    public function borrowed()
    {
        return view('reports.borrowed', [
            'borrows' => Borrow::with(['book', 'student'])->where('status', 'borrowed')->latest()->paginate(15),
        ]);
    }

    public function returned()
    {
        return view('reports.returned', [
            'borrows' => Borrow::with(['book', 'student'])->where('status', 'returned')->latest()->paginate(15),
        ]);
    }

    public function lost()
    {
        return view('reports.lost', [
            'lostBooks' => LostBook::with(['book', 'student'])->latest()->paginate(15),
        ]);
    }

    public function available()
    {
        return view('reports.available', [
            'books' => Book::with('category')->where('available_copies', '>', 0)->orderBy('title')->paginate(15),
        ]);
    }

    public function activeStudents()
    {
        return view('reports.active-students', [
            'students' => Student::whereHas('borrows', fn ($query) => $query->where('status', 'borrowed'))
                ->with(['borrows' => fn ($query) => $query->where('status', 'borrowed')->with('book')])
                ->orderBy('full_name')
                ->paginate(15),
        ]);
    }
}
