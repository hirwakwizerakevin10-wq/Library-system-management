<div class="space-y-4">
    <div>
        <label for="name">Name</label>
        <input id="name" name="name" value="{{ old('name', $category->name ?? '') }}" required placeholder="Fiction, Research, ICT...">
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>
    <div>
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4" placeholder="Short description for staff and reports">{{ old('description', $category->description ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>
</div>
