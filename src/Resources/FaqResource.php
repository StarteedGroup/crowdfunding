<?php

namespace Starteed\Resources;

use Starteed\Faq;
use Starteed\Resources\ResourceBase;
use Starteed\Resources\FaqTranslationResource;

class FaqResource extends ResourceBase
{
    public function __construct(Faq $faq, array $data)
    {
        parent::__construct($faq->starteed, "{$faq->endpoint}/{$this->id}", $data);
    	$this->setupEndpoints();
    }

    protected function setupEndpoints()
    {
        $this->translation = new FaqTranslationResource($this, (array) $this->translation->data);
    }
}