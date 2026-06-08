<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Kevin',
            'email' => 'kevin@gmail.com',
            'role' => User::ROLE_ADMIN,
            'password' => Hash::make('12345'),
            'email_verified_at' => now(),
        ]);

        $customer = User::create([
            'name' => 'Hirwa',
            'email' => 'hirwa@gmail.com',
            'role' => User::ROLE_CUSTOMER,
            'password' => Hash::make('12345'),
            'email_verified_at' => now(),
        ]);

        $category = Category::create([
            'name' => 'Literature',
            'description' => 'Fiction, fantasy, and classic writing.',
        ]);

        $student = Student::create([
            'full_name' => 'Hirwa Kwizera Kevin',
            'registration_number' => 'KH-2026-00001',
            'email' => 'hirwa@gmail.com',
            'department' => 'Literature',
            'user_id' => $customer->id,
        ]);

        Book::create([
            'category_id' => $category->id,
            'title' => 'Harry Potter',
            'author' => 'J.K. Rowling',
            'isbn' => '9780747532743',
            'quantity' => 5,
            'available_copies' => 5,
            'shelf_location' => 'C1-01',
            'status' => 'available',
        ]);
    }
}
