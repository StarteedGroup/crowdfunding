<?php

namespace Starteed\Resources;

use Starteed\Resources\FaqResource;
use Starteed\Resources\ResourceBase;

class FaqTranslationResource extends ResourceBase
{
    public function __construct(FaqResource $faq, array $data)
    {
        parent::__construct($faq->starteed, "faqs/{$faq->id}/translations/" . $data['id'], $data);
    }
}