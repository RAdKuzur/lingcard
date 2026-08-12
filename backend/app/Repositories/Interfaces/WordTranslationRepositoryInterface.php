<?php

namespace App\Repositories\Interfaces;

interface WordTranslationRepositoryInterface extends BaseRepositoryInterface
{
    public function getByTargetLanguageIdAndBaseLanguageId($baseLanguageId, $targetLanguageId);
    public function getPaginateByTargetLanguageIdAndBaseLanguageId($baseLanguageId, $targetLanguageId, $page, $limit, $search);
    public function countByTargetLanguageIdAndBaseLanguageId($baseLanguageId, $targetLanguageId, $search);
    public function getNewWord($baseLanguageId, $targetLanguageId, array $exceptId);
    public function getNewWords($baseLanguageId, $targetLanguageId, array $exceptId);
    public function getSearchNewWords($baseLanguageId, $targetLanguageId, array $exceptId, $page, $limit, $search);
    public function countSearchNewWords($baseLanguageId, $targetLanguageId, array $exceptId, $search);
}
