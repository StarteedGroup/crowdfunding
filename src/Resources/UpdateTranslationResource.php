<?php

namespace Starteed\Resources;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\UpdateResource;

class UpdateTranslationResource extends ResourceBase
{
    public function __construct(UpdateResource $update, array $data)
    {
        parent::__construct($update->starteed, "updates/{$update->id}/translations/" . $data['id'], $data);
    }
}