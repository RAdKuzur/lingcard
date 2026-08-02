<?php

namespace App\Services;

use App\DTO\LanguageDTO;
use App\DTO\LanguageMapDTO;
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
        $languages = $this->languageRepository->all();
        foreach ($languages as $language) {
            $data[] = (new LanguageDTO(
                id: $language->id,
                name: $language->name,
                code: $language->code
            ))->toArray();
        }
        return $data;
    }
    public function allActive() : array
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

    public function map() : array
    {
        $languageMapDTO = new LanguageMapDTO();
        $languages = $this->languageRepository->allActive();
        foreach ($languages as $language) {
            $availableCodes = [];
            foreach ($language->baseLanguages as $availableLanguage) {
                $availableCodes[] = $availableLanguage->targetLanguage->code;
            }
            $languageMapDTO->addItem([
                'code' => $language->code,
                'label' => $language->name,
                'available_codes' => $availableCodes,
            ]);
        }
        return $languageMapDTO->toArray();
    }
}
