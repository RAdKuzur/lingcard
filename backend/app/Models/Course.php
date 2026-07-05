<?php

namespace App\Models;

use App\Dictionaries\StatusDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $word_translation_id
 * @property int $user_id
 * @property int $repeat
 * @property int $status
 * @property Carbon|null $last_time_repeated
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read WordTranslation $wordTranslation
 * @property-read User $user
 */
class Course extends Model
{

    public const REPEAT_TIME = 5;
    use HasFactory;

    protected $fillable = [
        'word_translation_id',
        'user_id',
        'repeat',
        'status',
        'last_time_repeated',
    ];

    protected $casts = [
        'repeat' => 'integer',
        'status' => 'integer',
        'last_time_repeated' => 'datetime',
    ];

    protected $attributes = [
        'repeat' => 0,
        'status' => StatusDictionary::NONE,
    ];

    public function wordTranslation(): BelongsTo
    {
        return $this->belongsTo(WordTranslation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function incrementRepeat(): self
    {
        $this->increment('repeat');
        return $this;
    }

    public function updateStatus(int $status): self
    {
        $this->update(['status' => $status]);
        return $this;
    }

    public function updateLastTimeRepeated(): self
    {
        $this->update(['last_time_repeated' => now()]);
        return $this;
    }
}
