<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Book
 *
 * @property int $id
 * @property string $title
 * @property int|null $year
 * @property int $author_id
 * @property int $language_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Author $author
 * @property Language $language
 * @property Chapter[] $chapters
 *
 */
class Book extends Model
{
    use HasFactory;

    /**
     * Поля, разрешённые для массового заполнения.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'year',
        'author_id',
        'language_id',
    ];

    /**
     * Приведение типов.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'year' => 'integer',
        'author_id' => 'integer',
        'language_id' => 'integer',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}
