<?php

namespace App\Services;

use App\DTO\NewsDTO;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use DateTime;

class NewsService
{
    private NewsRepositoryInterface $newsRepository;
    public function __construct(
        NewsRepositoryInterface $newsRepository
    )
    {
        $this->newsRepository = $newsRepository;
    }

    public function all() : array
    {
        $data = [];
        $news = $this->newsRepository->allSorted();
        foreach ($news as $item) {
            $data[] = (new NewsDTO(
                id: $item->id,
                content: $item->content,
                date: (new DateTime($item->date))->format('d.m.Y H:i'),
                title: $item->title
            ))->toArray();
        }
        return $data;
    }
}
