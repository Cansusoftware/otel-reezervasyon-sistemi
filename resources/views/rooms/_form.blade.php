@php $room = $room ?? null; @endphp

<div class="row g-3">
    <div class="col-md-4">
        <label for="number" class="form-label">Oda Numarası</label>
        <input type="text" name="number" id="number"
               class="form-control @error('number') is-invalid @enderror"
               value="{{ old('number', $room?->number) }}" required>
        @error('number')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label for="type" class="form-label">Oda Tipi</label>
        <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
            @foreach(\App\Models\Room::TYPES as $key => $label)
                <option value="{{ $key }}" {{ old('type', $room?->type) === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label for="status" class="form-label">Durum</label>
        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
            @foreach(\App\Models\Room::STATUSES as $key => $label)
                <option value="{{ $key }}" {{ old('status', $room?->status ?? 'musait') === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label for="price_per_night" class="form-label">Gece Fiyatı (₺)</label>
        <input type="number" step="0.01" name="price_per_night" id="price_per_night"
               class="form-control @error('price_per_night') is-invalid @enderror"
               value="{{ old('price_per_night', $room?->price_per_night) }}" required>
        @error('price_per_night')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label for="capacity" class="form-label">Kapasite (kişi)</label>
        <input type="number" name="capacity" id="capacity" min="1" max="10"
               class="form-control @error('capacity') is-invalid @enderror"
               value="{{ old('capacity', $room?->capacity ?? 1) }}" required>
        @error('capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
