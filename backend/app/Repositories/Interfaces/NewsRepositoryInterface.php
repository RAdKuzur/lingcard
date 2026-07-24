<?php

namespace App\Repositories\Interfaces;

interface NewsRepositoryInterface extends BaseRepositoryInterface
{
    public function allSorted();
    public function findByLangId($langId);
    public function findApprovedNewsByLangId($langId);
    public function incrementViewsCount($id);
    public function incrementLikesCount($id);
    public function incrementDislikesCount($id);
    public function decrementLikesCount($id);
    public function decrementDislikesCount($id);
}
