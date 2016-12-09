<?php

namespace Starteed\Resources;

use Starteed\Faq;
use Starteed\Resources\ResourceBase;

class FaqResource extends ResourceBase
{
    public function __construct(Faq $faq, array $data)
    {
        parent::__construct($faq->starteed, "{$faq->endpoint}/{$this->id}", $data);
    }
}