<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $base_language_id
 * @property int $target_language_id
 *
 * @property Language|null $baseLanguage
 * @property Language|null $targetLanguage
 */
class AvailableLanguage extends Model
{

    protected $table = 'available_languages';
    protected $fillable = [
        'base_language_id',
        'target_language_id'
    ];

    public function baseLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'base_language_id');
    }
    public function targetLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'target_language_id');
    }
}
