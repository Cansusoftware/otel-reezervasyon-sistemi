<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = [
        'guest_id',
        'room_id',
        'check_in',
        'check_out',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
        ];
    }

    /** Rezervasyon durumları ve Türkçe karşılıkları */
    public const STATUSES = [
        'beklemede' => 'Beklemede',
        'giris_yapildi' => 'Giriş Yapıldı',
        'cikis_yapildi' => 'Çıkış Yapıldı',
        'iptal' => 'İptal',
    ];

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    /** Gece sayısını hesaplar */
    public function getNightCountAttribute(): int
    {
        return (int) $this->check_in->diffInDays($this->check_out);
    }

    /** Toplam tutarı hesaplar */
    public function getTotalPriceAttribute(): float
    {
        return $this->night_count * (float) $this->room->price_per_night;
    }

    /**
     * Belirtilen oda ve tarih aralığında çakışan rezervasyon var mı kontrol eder.
     */
    public static function hasConflict(int $roomId, string $checkIn, string $checkOut, ?int $excludeId = null): bool
    {
        return self::query()
            ->where('room_id', $roomId)
            ->where('status', '!=', 'iptal')
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn)
            ->exists();
    }
}
