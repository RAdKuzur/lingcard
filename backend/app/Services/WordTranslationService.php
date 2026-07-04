<?php

namespace App\Services;

use App\Dictionaries\LevelDictionary;
use App\DTO\WordTranslationDTO;
use App\Repositories\WordTranslationRepository;

class WordTranslationService
{
    private WordTranslationRepository $wordTranslationRepository;
    public function __construct(
        WordTranslationRepository $wordTranslationRepository
    )
    {
        $this->wordTranslationRepository = $wordTranslationRepository;
    }

    public function dictionary($baseTrainingId, $targetLanguageId) {
        $data = [];
        $wordTranslations = $this->wordTranslationRepository->getByTargetLanguageIdAndBaseLanguageId($baseTrainingId, $targetLanguageId);
        foreach ($wordTranslations as $wordTranslation) {
            $data[] = (new WordTranslationDTO(
                text: $wordTranslation->word->text,
                translation: $wordTranslation->translation,
                level: LevelDictionary::get($wordTranslation->word->level),
            ));
        }
        return $data;
    }
}
