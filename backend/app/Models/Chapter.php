<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Chapter
 *
 * @property int $id
 * @property int $number
 * @property string|null $name
 * @property int $book_id
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Book $book
 *
 */
class Chapter extends Model
{
    use HasFactory;

    /**
     * Поля, разрешённые для массового заполнения.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'number',
        'name',
        'book_id',
        'content',
    ];

    /**
     * Приведение типов.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'number' => 'integer',
        'book_id' => 'integer',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
