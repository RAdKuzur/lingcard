<?php

namespace App\Services;

use App\Dictionaries\StatusPostDictionary;
use App\DTO\PostDTO;
use App\Helpers\AuthHelper;
use App\Helpers\LogHelper;
use App\Repositories\Interfaces\LanguageRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\ReactionRepositoryInterface;
use DateTime;
use Illuminate\Support\Facades\DB;

class PostService
{
    private PostRepositoryInterface $postRepository;
    private LanguageRepositoryInterface $languageRepository;
    private ReactionRepositoryInterface $reactionRepository;
    public function __construct(
        PostRepositoryInterface     $postRepository,
        LanguageRepositoryInterface $languageRepository,
        ReactionRepositoryInterface $reactionRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->languageRepository = $languageRepository;
        $this->reactionRepository = $reactionRepository;
    }

    public function all() : array
    {
        $data = [];
        $posts = $this->postRepository->allSorted();
        foreach ($posts as $post) {
            $data[] = (new PostDTO(
                id: $post->id,
                content: $post->content,
                date: (new DateTime($post->date))->format('d.m.Y H:i'),
                title: $post->title,
                code: $post->language->code
            ))->toArray();
        }
        return $data;
    }
    public function one($id) : array
    {
        $user = AuthHelper::user();
        $post = $this->postRepository->find($id);
        $isLiked = $this->reactionRepository->isLiked($user->id, $id);
        $isDisliked = $this->reactionRepository->isDisliked($user->id, $id);
        $likesCount = $this->reactionRepository->countLikes($id);
        $dislikesCount = $this->reactionRepository->countDislikes($id);
            DB::beginTransaction();
        try {
            $this->postRepository->incrementViewsCount($id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::errorLog($e->getTrace(), $e->getMessage());
        }
        $data = (new PostDTO(
            id: $post->id,
            content: $post->content,
            date: (new DateTime($post->date))->format('d.m.Y H:i'),
            title: $post->title,
            code: $post->language->code,
            username: $post->user->name,
            address: $post->address,
            status: StatusPostDictionary::get($post->status),
            viewsCount: $post->views_count,
            likesCount: $likesCount,
            dislikesCount: $dislikesCount,
            isLiked: $isLiked,
            isDisliked: $isDisliked
        ))->toArray();
        return $data;
    }

    public function postsByCode($code) : array
    {
        $language = $this->languageRepository->findByCode($code);
        $data = [];
        if ($language) {
            $posts = $this->postRepository->findApprovedPostsByLangId($language->id);
            foreach ($posts as $post) {
                $data[] = (new PostDTO(
                    id: $post->id,
                    content: $post->content,
                    date: (new DateTime($post->date))->format('d.m.Y H:i'),
                    title: $post->title,
                    code: $code,
                    username: $post->user->name,
                    address: $post->address,
                    status: StatusPostDictionary::get($post->status),
                ))->toArray();
            }
        }
        return $data;
    }
}
