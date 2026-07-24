<?php

namespace App\Services;

use App\Dictionaries\StatusNewsDictionary;
use App\DTO\NewsDTO;
use App\Helpers\AuthHelper;
use App\Helpers\LogHelper;
use App\Repositories\Interfaces\LanguageRepositoryInterface;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use App\Repositories\Interfaces\ReactionRepositoryInterface;
use DateTime;
use Illuminate\Support\Facades\DB;

class NewsService
{
    private NewsRepositoryInterface $newsRepository;
    private LanguageRepositoryInterface $languageRepository;
    private ReactionRepositoryInterface $reactionRepository;
    public function __construct(
        NewsRepositoryInterface $newsRepository,
        LanguageRepositoryInterface $languageRepository,
        ReactionRepositoryInterface $reactionRepository
    )
    {
        $this->newsRepository = $newsRepository;
        $this->languageRepository = $languageRepository;
        $this->reactionRepository = $reactionRepository;
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
    public function one($id) : array
    {
        $user = AuthHelper::user();
        DB::beginTransaction();
        try {
            $this->newsRepository->incrementViewsCount($id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::errorLog($e->getTrace(), $e->getMessage());
        }
        $news = $this->newsRepository->find($id);
        $isLiked = $this->reactionRepository->isLiked($user->id, $id);
        $isDisliked = $this->reactionRepository->isDisliked($user->id, $id);
        $data = (new NewsDTO(
            id: $news->id,
            content: $news->content,
            date: (new DateTime($news->date))->format('d.m.Y H:i'),
            title: $news->title,
            code: $news->language->code,
            username: $news->user->name,
            address: $news->address,
            status: StatusNewsDictionary::get($news->status),
            viewsCount: $news->views_count,
            likesCount: $news->likes_count,
            dislikesCount: $news->dislikes_count,
            isLiked: $isLiked,
            isDisliked: $isDisliked
        ))->toArray();
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
