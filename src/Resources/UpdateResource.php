<?php

namespace Starteed\Resources;

use Starteed\Update;
use Starteed\Resources\ResourceBase;
use Starteed\Resources\UpdateTranslationResource;

class UpdateResource extends ResourceBase
{
    protected $campaign;

    public function __construct(Update $update, array $data)
    {
        $this->campaign = $update->campaign;
        parent::__construct($update->starteed, "{$update->endpoint}/{$this->id}", $data);
        $this->setupEndpoints();
    }

    protected function setupEndpoints()
    {
        $this->translation = new UpdateTranslationResource($this, (array) $this->translation->data);
    }
}