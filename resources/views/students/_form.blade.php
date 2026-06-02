<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label for="full_name">Full Name</label>
        <input id="full_name" name="full_name" value="{{ old('full_name', $student->full_name ?? '') }}" required>
        <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
    </div>
    <div>
        <label for="registration_number">Registration Number</label>
        <input id="registration_number" name="registration_number" value="{{ old('registration_number', $student->registration_number ?? '') }}" required>
        <x-input-error :messages="$errors->get('registration_number')" class="mt-2" />
    </div>
    <div>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email', $student->email ?? '') }}" required>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
    <div>
        <label for="phone">Phone Number</label>
        <input id="phone" name="phone" value="{{ old('phone', $student->phone ?? '') }}" placeholder="+250 ...">
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
    </div>
    <div class="md:col-span-2">
        <label for="department">Department/Class</label>
        <input id="department" name="department" value="{{ old('department', $student->department ?? '') }}" required>
        <x-input-error :messages="$errors->get('department')" class="mt-2" />
    </div>
</div>
