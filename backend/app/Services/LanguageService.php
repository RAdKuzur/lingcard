<?php

namespace App\Services;

use App\DTO\LanguageDTO;
use App\Repositories\Interfaces\LanguageRepositoryInterface;

class LanguageService
{
    private LanguageRepositoryInterface $languageRepository;
    public function __construct(
        LanguageRepositoryInterface $languageRepository
    )
    {
        $this->languageRepository = $languageRepository;
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

    public function exceptLanguage($id) : array
    {
        $data = [];
        $languages = $this->languageRepository->all();
        foreach ($languages as $language) {
            if ($language->id != $id) {
                $data[] = (new LanguageDTO(
                    id: $language->id,
                    name: $language->name,
                    code: $language->code
                ))->toArray();
            }
        }
        return $data;
    }
}
