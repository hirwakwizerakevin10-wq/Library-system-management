<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\LostBook;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedAdministrators();

        $categories = $this->seedCategories();
        $students = $this->seedCustomers();
        $books = $this->seedBooks($categories);

        $this->seedBorrowingRecords($students, $books);
    }

    private function seedAdministrators(): void
    {
        foreach ([
            ['name' => 'Knowledge Hub Administrator', 'email' => 'admin@library.test'],
            ['name' => 'Operations Administrator', 'email' => 'admin2@library.test'],
        ] as $admin) {
            User::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'role' => User::ROLE_ADMIN,
                    'password' => Hash::make('password'),
                ],
            );
        }
    }

    private function seedCategories()
    {
        return collect([
            ['name' => 'Computer Science', 'description' => 'Programming, systems, and data books.'],
            ['name' => 'Business', 'description' => 'Management, finance, and entrepreneurship.'],
            ['name' => 'Literature', 'description' => 'Novels, poetry, and classic writing.'],
            ['name' => 'Science', 'description' => 'Biology, physics, chemistry, and general science.'],
            ['name' => 'Reference', 'description' => 'Dictionaries, manuals, and study guides.'],
        ])->mapWithKeys(fn (array $category) => [
            $category['name'] => Category::updateOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']],
            ),
        ]);
    }

    private function seedCustomers()
    {
        $demoUser = User::updateOrCreate(
            ['email' => 'customer@library.test'],
            [
                'name' => 'Demo Customer',
                'role' => User::ROLE_CUSTOMER,
                'password' => Hash::make('password'),
            ],
        );

        return collect([
            ['full_name' => 'Demo Customer', 'registration_number' => 'KH-2026-00001', 'email' => 'customer@library.test', 'phone' => '555-0100', 'department' => 'Reference Studies', 'user_id' => $demoUser->id],
            ['full_name' => 'Amina Johnson', 'registration_number' => 'LIB-2026-001', 'email' => 'amina@example.com', 'phone' => '555-0101', 'department' => 'Computer Science', 'user_id' => null],
            ['full_name' => 'Marcus Lee', 'registration_number' => 'LIB-2026-002', 'email' => 'marcus@example.com', 'phone' => '555-0102', 'department' => 'Business Administration', 'user_id' => null],
            ['full_name' => 'Sofia Patel', 'registration_number' => 'LIB-2026-003', 'email' => 'sofia@example.com', 'phone' => '555-0103', 'department' => 'Literature', 'user_id' => null],
            ['full_name' => 'Daniel Kim', 'registration_number' => 'LIB-2026-004', 'email' => 'daniel@example.com', 'phone' => '555-0104', 'department' => 'Science', 'user_id' => null],
            ['full_name' => 'Grace Miller', 'registration_number' => 'LIB-2026-005', 'email' => 'grace@example.com', 'phone' => '555-0105', 'department' => 'Reference Studies', 'user_id' => null],
        ])->mapWithKeys(fn (array $student) => [
            $student['registration_number'] => Student::updateOrCreate(
                ['registration_number' => $student['registration_number']],
                $student,
            ),
        ]);
    }

    private function seedBooks($categories)
    {
        return collect([
            ['category' => 'Computer Science', 'title' => 'Clean Code', 'author' => 'Robert C. Martin', 'isbn' => '9780132350884', 'quantity' => 8, 'available_copies' => 7, 'shelf_location' => 'A1-02', 'status' => 'available'],
            ['category' => 'Computer Science', 'title' => 'Introduction to Algorithms', 'author' => 'Cormen, Leiserson, Rivest, Stein', 'isbn' => '9780262046305', 'quantity' => 5, 'available_copies' => 4, 'shelf_location' => 'A1-04', 'status' => 'available'],
            ['category' => 'Business', 'title' => 'The Lean Startup', 'author' => 'Eric Ries', 'isbn' => '9780307887894', 'quantity' => 6, 'available_copies' => 6, 'shelf_location' => 'B2-01', 'status' => 'available'],
            ['category' => 'Literature', 'title' => 'Things Fall Apart', 'author' => 'Chinua Achebe', 'isbn' => '9780385474542', 'quantity' => 10, 'available_copies' => 9, 'shelf_location' => 'C3-05', 'status' => 'available'],
            ['category' => 'Science', 'title' => 'A Brief History of Time', 'author' => 'Stephen Hawking', 'isbn' => '9780553380163', 'quantity' => 4, 'available_copies' => 4, 'shelf_location' => 'D4-03', 'status' => 'available'],
            ['category' => 'Reference', 'title' => 'Oxford English Dictionary', 'author' => 'Oxford Languages', 'isbn' => '9780199571123', 'quantity' => 3, 'available_copies' => 2, 'shelf_location' => 'R1-01', 'status' => 'available'],
            ['category' => 'Business', 'title' => 'Atomic Habits', 'author' => 'James Clear', 'isbn' => '9780735211292', 'quantity' => 7, 'available_copies' => 7, 'shelf_location' => 'B2-04', 'status' => 'available'],
        ])->mapWithKeys(function (array $book) use ($categories) {
            $category = $book['category'];
            unset($book['category']);

            $book['category_id'] = $categories[$category]->id;

            return [
                $book['isbn'] => Book::updateOrCreate(
                    ['isbn' => $book['isbn']],
                    $book,
                ),
            ];
        });
    }

    private function seedBorrowingRecords($students, $books): void
    {
        Borrow::updateOrCreate(
            ['student_id' => $students['LIB-2026-001']->id, 'book_id' => $books['9780132350884']->id, 'status' => 'borrowed'],
            [
                'borrow_date' => now()->subDays(5)->toDateString(),
                'due_date' => now()->addDays(9)->toDateString(),
                'notes' => 'Course reference copy.',
            ],
        );

        Borrow::updateOrCreate(
            ['student_id' => $students['LIB-2026-002']->id, 'book_id' => $books['9780262046305']->id, 'status' => 'borrowed'],
            [
                'borrow_date' => now()->subDays(3)->toDateString(),
                'due_date' => now()->addDays(11)->toDateString(),
            ],
        );

        Borrow::updateOrCreate(
            ['student_id' => $students['KH-2026-00001']->id, 'book_id' => $books['9780735211292']->id, 'status' => 'pending'],
            [
                'borrow_date' => now()->toDateString(),
                'due_date' => now()->addDays(14)->toDateString(),
                'notes' => 'Demo customer borrow request awaiting admin approval.',
            ],
        );

        Borrow::updateOrCreate(
            ['student_id' => $students['LIB-2026-003']->id, 'book_id' => $books['9780385474542']->id, 'status' => 'returned'],
            [
                'borrow_date' => now()->subDays(18)->toDateString(),
                'due_date' => now()->subDays(4)->toDateString(),
                'return_date' => now()->subDay()->toDateString(),
            ],
        );

        $lostBorrow = Borrow::updateOrCreate(
            ['student_id' => $students['LIB-2026-005']->id, 'book_id' => $books['9780199571123']->id, 'status' => 'lost'],
            [
                'borrow_date' => now()->subDays(20)->toDateString(),
                'due_date' => now()->subDays(6)->toDateString(),
                'notes' => 'Reported missing after locker damage.',
            ],
        );

        LostBook::updateOrCreate(
            ['borrow_id' => $lostBorrow->id],
            [
                'student_id' => $students['LIB-2026-005']->id,
                'book_id' => $books['9780199571123']->id,
                'quantity' => 1,
                'lost_date' => now()->subDays(2)->toDateString(),
                'notes' => 'Replacement pending.',
            ],
        );
    }
}
