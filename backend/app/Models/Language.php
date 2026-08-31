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
 * @property bool $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Word[]|HasMany $words
 * @property-read WordTranslation[]|HasMany $wordTranslations
 * @property-read Post[]|HasMany $posts
 *
 * @property-read AvailableLanguage[]|null $baseLanguages
 * @property-read AvailableLanguage[]|null $availableLanguages
 */
class Language extends Model
{
    use HasFactory;

    protected $table = 'languages';

    protected $fillable = [
        'name',
        'code',
        'is_active'
    ];

    public function words(): HasMany
    {
        return $this->hasMany(Word::class);
    }

    public function wordTranslations(): HasMany
    {
        return $this->hasMany(WordTranslation::class, 'target_language_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'language_id');
    }

    public function baseLanguages() : HasMany
    {
        return $this->hasMany(AvailableLanguage::class, 'base_language_id');
    }
    public function targetLanguages() : HasMany
    {
        return $this->hasMany(AvailableLanguage::class, 'target_language_id');
    }
}
