<?php

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Student;
use App\Models\User;

test('guests are redirected away from protected library pages', function () {
    foreach (['/dashboard', '/books', '/borrows', '/students', '/reports/borrowed'] as $uri) {
        $this->get($uri)->assertRedirect(route('login', absolute: false));
    }
});

test('customers cannot access administrator areas', function () {
    $customer = User::factory()->create(['role' => User::ROLE_CUSTOMER]);
    Student::factory()->create(['user_id' => $customer->id, 'email' => $customer->email]);

    $this->actingAs($customer)->get('/students')->assertForbidden();
    $this->actingAs($customer)->get('/reports/borrowed')->assertForbidden();
    $this->actingAs($customer)->get('/categories')->assertForbidden();
});

test('customers only see their own borrowing records', function () {
    $customer = User::factory()->create(['role' => User::ROLE_CUSTOMER]);
    $student = Student::factory()->create(['user_id' => $customer->id, 'email' => $customer->email]);
    $otherStudent = Student::factory()->create();
    $book = Book::factory()->create(['title' => 'Visible Customer Book']);
    $otherBook = Book::factory()->create(['title' => 'Hidden Customer Book']);

    Borrow::create([
        'student_id' => $student->id,
        'book_id' => $book->id,
        'borrow_date' => now()->toDateString(),
        'due_date' => now()->addDays(14)->toDateString(),
        'status' => 'borrowed',
    ]);

    Borrow::create([
        'student_id' => $otherStudent->id,
        'book_id' => $otherBook->id,
        'borrow_date' => now()->toDateString(),
        'due_date' => now()->addDays(14)->toDateString(),
        'status' => 'borrowed',
    ]);

    $this->actingAs($customer)
        ->get('/borrows')
        ->assertOk()
        ->assertSee('Visible Customer Book')
        ->assertDontSee('Hidden Customer Book');
});

test('customers can submit borrow requests and administrators can approve them', function () {
    $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
    $customer = User::factory()->create(['role' => User::ROLE_CUSTOMER]);
    $student = Student::factory()->create(['user_id' => $customer->id, 'email' => $customer->email]);
    $book = Book::factory()->create(['available_copies' => 2, 'quantity' => 2]);

    $this->actingAs($customer)
        ->post('/borrows', [
            'book_id' => $book->id,
            'notes' => 'Please approve this request.',
        ])
        ->assertRedirect(route('borrows.index', absolute: false));

    $borrow = Borrow::where('student_id', $student->id)->where('book_id', $book->id)->firstOrFail();

    expect($borrow->status)->toBe('pending');

    $this->actingAs($admin)
        ->post(route('borrows.approve', $borrow))
        ->assertRedirect(route('borrows.index', absolute: false));

    expect($borrow->fresh()->status)->toBe('borrowed');
    expect($book->fresh()->available_copies)->toBe(1);
});
