<?php

namespace App\Services;

use App\DTO\LanguageDTO;
use App\Repositories\Interfaces\AvailableLanguageRepositoryInterface;
use App\Repositories\Interfaces\LanguageRepositoryInterface;

class LanguageService
{
    private LanguageRepositoryInterface $languageRepository;
    private AvailableLanguageRepositoryInterface $availableLanguageRepository;
    public function __construct(
        LanguageRepositoryInterface $languageRepository,
        AvailableLanguageRepositoryInterface $availableLanguageRepository
    )
    {
        $this->languageRepository = $languageRepository;
        $this->availableLanguageRepository = $availableLanguageRepository;
    }

    public function all() : array
    {
        $data = [];
        $languages = $this->languageRepository->allActive();
        foreach ($languages as $language) {
            $data[] = (new LanguageDTO(
                id: $language->id,
                name: $language->name,
                code: $language->code
            ))->toArray();
        }
        return $data;
    }

    public function exceptLanguage($id) : array
    {
        $data = [];
        $availableLanguages = $this->availableLanguageRepository->findByBaseLanguageId($id);
        foreach ($availableLanguages as $availableLanguage) {
            $language = $availableLanguage->targetLanguage;
            $data[] = (new LanguageDTO(
                id: $language->id,
                name: $language->name,
                code: $language->code
            ))->toArray();
        }
        return $data;
    }
}
