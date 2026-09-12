<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\App;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name_tr',
        'name_en',
        'description_tr',
        'description_en',
        'icon',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_badges')
            ->withPivot('earned_at')
            ->withTimestamps();
    }

    public function getNameAttribute(): string
    {
        return App::getLocale() === 'tr' ? $this->name_tr : $this->name_en;
    }

    public function getDescriptionAttribute(): string
    {
        return App::getLocale() === 'tr' ? $this->description_tr : $this->description_en;
    }
}
