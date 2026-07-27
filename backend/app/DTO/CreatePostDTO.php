<?php

namespace App\DTO;

use App\Dictionaries\StatusPostDictionary;

class CreatePostDTO implements BaseDTO
{
    public ?string $content = null;
    public ?string $title = null;
    public ?string $languageId = null;
    public ?string $address = null;
    public ?int $status = null;
    public $date = null;
    public ?int $viewsCount = null;
    public ?int $likesCount = null;
    public ?int $dislikesCount = null;
    public ?int $userId = null;
    public function __construct(
        ?string $content = null,
        ?string $title = null,
        ?int $languageId = null,
        ?string $address = null,
        ?int $status = null,
        $date = null,
        ?int $viewsCount = null,
        ?int $likesCount = null,
        ?int $dislikesCount = null,
        ?int $userId = null
    )
    {
        $this->content = $content;
        $this->title = $title;
        $this->languageId = $languageId;
        $this->address = $address;
        $this->status = $status;
        $this->date = $date;
        $this->viewsCount = $viewsCount;
        $this->likesCount = $likesCount;
        $this->dislikesCount = $dislikesCount;
        $this->userId = $userId;
    }
    public function toArray(): array
    {
        return [
            'content' => $this->content,
            'title' => $this->title,
            'language_id' => $this->languageId,
            'address' => $this->address,
            'status' => $this->status,
            'date' => $this->date,
            'views_count' => $this->viewsCount,
            'likes_count' => $this->likesCount,
            'dislikes_count' => $this->dislikesCount,
            'user_id' => $this->userId
        ];
    }

    public function setExtraAttributes($userId) : void
    {
        $this->status = StatusPostDictionary::WAITING;
        $this->date = now();
        $this->viewsCount = 0;
        $this->likesCount = 0;
        $this->dislikesCount = 0;
        $this->userId = $userId;
    }
}
