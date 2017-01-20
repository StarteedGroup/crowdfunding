<?php

namespace Starteed\Resources;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\RewardResource;

class RewardTranslationResource extends ResourceBase
{
    public function __construct(RewardResource $reward, array $data)
    {
        parent::__construct($reward->starteed, "rewards/{$reward->id}/translations/" . $data['id'], $data);
    }
}