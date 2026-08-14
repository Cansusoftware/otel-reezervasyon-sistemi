@php $reservation = $reservation ?? null; @endphp

<div class="row g-3">
    <div class="col-md-6">
        <label for="guest_id" class="form-label">Misafir</label>
        <select name="guest_id" id="guest_id" class="form-select @error('guest_id') is-invalid @enderror" required>
            <option value="">Misafir seçin...</option>
            @foreach($guests as $guest)
                <option value="{{ $guest->id }}" {{ old('guest_id', $reservation?->guest_id) == $guest->id ? 'selected' : '' }}>
                    {{ $guest->full_name }} — {{ $guest->phone }}
                </option>
            @endforeach
        </select>
        @error('guest_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="room_id" class="form-label">Oda</label>
        <select name="room_id" id="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
            <option value="">Oda seçin...</option>
            @foreach($rooms as $room)
                <option value="{{ $room->id }}" {{ old('room_id', $reservation?->room_id) == $room->id ? 'selected' : '' }}>
                    {{ $room->number }} — {{ $room->type_label }} ({{ number_format($room->price_per_night, 0, ',', '.') }} ₺/gece)
                </option>
            @endforeach
        </select>
        @error('room_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label for="check_in" class="form-label">Giriş Tarihi</label>
        <input type="date" name="check_in" id="check_in"
               class="form-control @error('check_in') is-invalid @enderror"
               value="{{ old('check_in', $reservation?->check_in?->format('Y-m-d')) }}" required>
        @error('check_in')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label for="check_out" class="form-label">Çıkış Tarihi</label>
        <input type="date" name="check_out" id="check_out"
               class="form-control @error('check_out') is-invalid @enderror"
               value="{{ old('check_out', $reservation?->check_out?->format('Y-m-d')) }}" required>
        @error('check_out')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label for="status" class="form-label">Durum</label>
        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
            @foreach(\App\Models\Reservation::STATUSES as $key => $label)
                <option value="{{ $key }}" {{ old('status', $reservation?->status ?? 'beklemede') === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label for="notes" class="form-label">Notlar (isteğe bağlı)</label>
        <textarea name="notes" id="notes" rows="3"
                  class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $reservation?->notes) }}</textarea>
        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
