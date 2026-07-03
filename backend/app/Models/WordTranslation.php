<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $word_id
 * @property int $target_language_id
 * @property string|null $translation
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Word $word
 * @property-read Language $targetLanguage
 * @property-read Course[]|HasMany $courses
 */
class WordTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'word_id',
        'target_language_id',
        'translation',
    ];

    protected $casts = [
        'translation' => 'string',
    ];

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }

    public function targetLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'target_language_id');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
