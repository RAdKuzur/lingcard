<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $text
 * @property int $language_id
 * @property int $level
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Language $language
 * @property-read WordTranslation[]|HasMany $wordTranslations
 */
class Word extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'language_id',
        'level',
    ];

    protected $casts = [
        'level' => 'integer',
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function wordTranslations(): HasMany
    {
        return $this->hasMany(WordTranslation::class);
    }
}
