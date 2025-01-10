<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rooms';
    protected $guarded = ['id'];

    public function boardingHouse(): BelongsTo
    {
        return $this->belongsTo(BoardingHouse::class, 'room_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'room_id');
    }

    public function roomImages(): HasMany
    {
        return $this->hasMany(RoomImage::class, 'room_id');
    }
}
