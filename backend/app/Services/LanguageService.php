<?php

namespace App\Services;

use App\DTO\LanguageDTO;
use App\Repositories\LanguageRepository;

class LanguageService
{
    private LanguageRepository $languageRepository;
    public function __construct(
        LanguageRepository $languageRepository
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
