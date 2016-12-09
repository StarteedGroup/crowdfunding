<?php

namespace Starteed\Resources;

use Starteed\Supporter;
use Starteed\Resources\ResourceBase;

class SupporterResource extends ResourceBase
{
    public function __construct(Supporter $supporter, array $data)
    {
        parent::__construct($supporter->starteed, $supporter->endpoint . '/' . $data['id'], $data);
    }
}