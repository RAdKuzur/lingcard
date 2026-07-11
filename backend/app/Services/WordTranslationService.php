<?php

namespace App\Services;

use App\Dictionaries\LevelDictionary;
use App\DTO\WordTranslationDTO;
use App\Repositories\Interfaces\WordTranslationRepositoryInterface;

class WordTranslationService
{
    private WordTranslationRepositoryInterface $wordTranslationRepository;
    public function __construct(
        WordTranslationRepositoryInterface $wordTranslationRepository
    )
    {
        $this->wordTranslationRepository = $wordTranslationRepository;
    }

    public function dictionary($baseTrainingId, $targetLanguageId, $page, $limit, $search) : array
    {
        $data = [];
        $wordTranslations = $this->wordTranslationRepository->getPaginateByTargetLanguageIdAndBaseLanguageId($baseTrainingId, $targetLanguageId, $page, $limit, $search);
        foreach ($wordTranslations as $wordTranslation) {
            $data[] = (new WordTranslationDTO(
                id: $wordTranslation->id,
                text: $wordTranslation->word->text,
                translation: $wordTranslation->translation,
                level: LevelDictionary::get($wordTranslation->word->level),
            ));
        }
        return [
            'data' => $data,
            'amountWords' => $this->wordTranslationRepository->countByTargetLanguageIdAndBaseLanguageId($baseTrainingId, $targetLanguageId, $search),
        ];
    }
}
