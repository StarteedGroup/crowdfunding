<?php

namespace Starteed\Resources;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\SectionResource;

class SectionTranslationResource extends ResourceBase
{
    public function __construct(SectionResource $section, array $data)
    {
        parent::__construct($section->starteed, "sections/{$section->id}/translations/" . $data['id'], $data);
    }
}