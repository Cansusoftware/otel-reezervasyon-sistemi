<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'number',
        'type',
        'status',
        'price_per_night',
        'capacity',
    ];

    protected function casts(): array
    {
        return [
            'price_per_night' => 'decimal:2',
        ];
    }

    /** Oda tipleri ve Türkçe karşılıkları */
    public const TYPES = [
        'tek' => 'Tek Kişilik',
        'cift' => 'Çift Kişilik',
        'suit' => 'Suit',
    ];

    /** Oda durumları ve Türkçe karşılıkları */
    public const STATUSES = [
        'musait' => 'Müsait',
        'dolu' => 'Dolu',
        'bakim' => 'Bakımda',
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
