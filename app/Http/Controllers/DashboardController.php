<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\LostBook;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->user()->isCustomer()) {
            $student = $request->user()->student;

            return view('dashboard', [
                'availableBooks' => Book::with('category')->where('available_copies', '>', 0)->latest()->take(6)->get(),
                'customerBorrows' => Borrow::with('book.category')
                    ->where('student_id', $student?->id)
                    ->latest()
                    ->take(6)
                    ->get(),
                'pendingRequests' => Borrow::where('student_id', $student?->id)->where('status', 'pending')->count(),
                'activeBorrows' => Borrow::where('student_id', $student?->id)->where('status', 'borrowed')->count(),
            ]);
        }

        return view('dashboard', [
            'totalBooks' => Book::sum('quantity'),
            'availableBooks' => Book::sum('available_copies'),
            'borrowedBooks' => Borrow::where('status', 'borrowed')->count(),
            'pendingBorrows' => Borrow::where('status', 'pending')->count(),
            'lostBooks' => LostBook::sum('quantity'),
            'totalStudents' => Student::count(),
            'recentBorrows' => Borrow::with(['book', 'student'])->latest()->take(8)->get(),
            'categoryStats' => \App\Models\Category::withCount('books')->orderByDesc('books_count')->take(6)->get(),
        ]);
    }
}
