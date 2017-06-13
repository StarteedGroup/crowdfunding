<?php

namespace Starteed\Resources;

use Starteed\SelfCrowdfunding;
use Starteed\Resources\ResourceBase;
use Starteed\Resources\SectionTranslationResource;

class SectionResource extends ResourceBase
{
    public function __construct(SelfCrowdfunding $starteed, array $data)
    {
        parent::__construct($starteed, 'sections', $data);
        $this->setupEndpoints();
    }

    protected function setupEndpoints()
    {
        $this->translation = new SectionTranslationResource($this, (array) $this->translation->data);
    }
}