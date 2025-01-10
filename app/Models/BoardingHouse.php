<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BoardingHouse extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'boarding_houses';
    protected $guarded = ['id'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'boarding_house_id');
    }

    public function bonuses(): HasMany
    {
        return $this->hasMany(Bonus::class, 'boarding_house_id');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class, 'boarding_house_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'boarding_house_id');
    }
}
