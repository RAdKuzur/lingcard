<?php

namespace App\Repositories\Interfaces;

interface WordTranslationRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllWithWords();
    public function getByTargetLanguageIdAndBaseLanguageId($baseLanguageId, $targetLanguageId);
    public function getPaginateByTargetLanguageIdAndBaseLanguageId($baseLanguageId, $targetLanguageId, $page, $limit, $search);
    public function countByTargetLanguageIdAndBaseLanguageId($baseLanguageId, $targetLanguageId, $search);
}
