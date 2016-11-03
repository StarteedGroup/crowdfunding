<?php

namespace Starteed\Resources;

use Starteed\Faq;
use Starteed\Resources\ResourceBase;

class FaqResource extends ResourceBase
{
    public function __construct(Faq $faq, array $data)
    {
        $this->resource = json_decode(json_encode($data));
        parent::__construct($faq->starteed, "{$faq->endpoint}/{$this->id}");
    }

    public function __get($property)
    {
        if (property_exists($this->resource, $property)) {
          return $this->resource->$property;
        }
    }
}