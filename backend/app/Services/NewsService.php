<?php

namespace App\Services;

use App\Dictionaries\StatusNewsDictionary;
use App\DTO\NewsDTO;
use App\Repositories\Interfaces\LanguageRepositoryInterface;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use DateTime;

class NewsService
{
    private NewsRepositoryInterface $newsRepository;
    private LanguageRepositoryInterface $languageRepository;
    public function __construct(
        NewsRepositoryInterface $newsRepository,
        LanguageRepositoryInterface $languageRepository
    )
    {
        $this->newsRepository = $newsRepository;
        $this->languageRepository = $languageRepository;
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
                title: $item->title,
                code: $item->language->code
            ))->toArray();
        }
        return $data;
    }


    public function newsByCode($code) : array
    {
        $language = $this->languageRepository->findByCode($code);
        $data = [];
        if ($language) {
            $news = $this->newsRepository->findApprovedNewsByLangId($language->id);
            foreach ($news as $item) {
                $data[] = (new NewsDTO(
                    id: $item->id,
                    content: $item->content,
                    date: (new DateTime($item->date))->format('d.m.Y H:i'),
                    title: $item->title,
                    code: $code,
                    username: $item->user->name,
                    address: $item->address,
                    status: StatusNewsDictionary::get($item->status),
                ))->toArray();
            }
        }
        return $data;
    }
}
