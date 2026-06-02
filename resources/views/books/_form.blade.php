<div class="grid gap-4 md:grid-cols-12">
    <div class="md:col-span-8">
        <label for="title">Title</label>
        <input id="title" name="title" value="{{ old('title', $book->title ?? '') }}" required placeholder="e.g. We Should All Be Feminists">
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>
    <div class="md:col-span-4">
        <label for="category_id">Category</label>
        <select id="category_id" name="category_id" required>
            <option value="">Choose category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $book->category_id ?? '') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
    </div>
    <div class="md:col-span-6">
        <label for="author">Author</label>
        <input id="author" name="author" value="{{ old('author', $book->author ?? '') }}" required placeholder="Author name">
        <x-input-error :messages="$errors->get('author')" class="mt-2" />
    </div>
    <div class="md:col-span-6">
        <label for="isbn">ISBN</label>
        <input id="isbn" name="isbn" value="{{ old('isbn', $book->isbn ?? '') }}" required placeholder="ISBN or internal code">
        <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
    </div>
    <div class="md:col-span-4">
        <label for="quantity">Total Copies</label>
        <input id="quantity" type="number" min="0" name="quantity" value="{{ old('quantity', $book->quantity ?? 1) }}" required>
        <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
    </div>
    <div class="md:col-span-4">
        <label for="available_copies">Available Copies</label>
        <input id="available_copies" type="number" min="0" name="available_copies" value="{{ old('available_copies', $book->available_copies ?? 1) }}" required>
        <x-input-error :messages="$errors->get('available_copies')" class="mt-2" />
    </div>
    <div class="md:col-span-4">
        <label for="shelf_location">Shelf or Location</label>
        <input id="shelf_location" name="shelf_location" value="{{ old('shelf_location', $book->shelf_location ?? '') }}" placeholder="Aisle A, Shelf 3">
        <x-input-error :messages="$errors->get('shelf_location')" class="mt-2" />
    </div>
</div>
