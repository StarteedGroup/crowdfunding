<?php

namespace Starteed\Resources;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\CampaignResource;

class CampaignTranslationResource extends ResourceBase
{
    public function __construct(CampaignResource $campaign, array $data)
    {
        parent::__construct($campaign->starteed, 'campaigns/' . $campaign->id . '/translations/' . $data['id'], $data);
    }
}