<?php

namespace Starteed\Resources;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\CampaignResource;

class CurrencyResource extends ResourceBase
{
    public function __construct(CampaignResource $campaign, array $data)
    {
        parent::__construct($campaign->starteed, '', $data);
    }
}