<?php

namespace Starteed\Resources;

use Starteed\Supporter;
use Starteed\Resources\ResourceBase;

class SupporterResource extends ResourceBase
{
    public function __construct(Supporter $supporter, array $data)
    {
        $this->resource = json_decode(json_encode($data));
        parent::__construct($supporter->starteed, "{$supporter->endpoint}/{$this->id}");
    }
}