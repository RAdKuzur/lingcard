<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Word[]|HasMany $words
 * @property-read WordTranslation[]|HasMany $wordTranslations
 */
class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
    ];

    public function words(): HasMany
    {
        return $this->hasMany(Word::class);
    }

    public function wordTranslations(): HasMany
    {
        return $this->hasMany(WordTranslation::class, 'target_language_id');
    }
}
