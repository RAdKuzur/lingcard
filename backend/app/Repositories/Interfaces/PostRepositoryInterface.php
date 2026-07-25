<?php

namespace App\Repositories\Interfaces;

interface PostRepositoryInterface extends BaseRepositoryInterface
{
    public function allSorted();
    public function findByLangId($langId);
    public function findApprovedPostsByLangId($langId);
    public function incrementViewsCount($id);
    public function incrementLikesCount($id);
    public function incrementDislikesCount($id);
    public function decrementLikesCount($id);
    public function decrementDislikesCount($id);
}
