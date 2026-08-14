@php $guest = $guest ?? null; @endphp

<div class="row g-3">
    <div class="col-md-6">
        <label for="first_name" class="form-label">Ad</label>
        <input type="text" name="first_name" id="first_name"
               class="form-control @error('first_name') is-invalid @enderror"
               value="{{ old('first_name', $guest?->first_name) }}" required>
        @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="last_name" class="form-label">Soyad</label>
        <input type="text" name="last_name" id="last_name"
               class="form-control @error('last_name') is-invalid @enderror"
               value="{{ old('last_name', $guest?->last_name) }}" required>
        @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="phone" class="form-label">Telefon</label>
        <input type="text" name="phone" id="phone"
               class="form-control @error('phone') is-invalid @enderror"
               value="{{ old('phone', $guest?->phone) }}" required>
        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label">E-posta (isteğe bağlı)</label>
        <input type="email" name="email" id="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $guest?->email) }}">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="id_number" class="form-label">TC Kimlik / Pasaport No (isteğe bağlı)</label>
        <input type="text" name="id_number" id="id_number"
               class="form-control @error('id_number') is-invalid @enderror"
               value="{{ old('id_number', $guest?->id_number) }}">
        @error('id_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label for="notes" class="form-label">Notlar (isteğe bağlı)</label>
        <textarea name="notes" id="notes" rows="3"
                  class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $guest?->notes) }}</textarea>
        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
