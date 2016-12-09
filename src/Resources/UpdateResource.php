<?php

namespace Starteed\Resources;

use Starteed\Update;
use Starteed\Resources\ResourceBase;

class UpdateResource extends ResourceBase
{
    protected $campaign;

    public function __construct(Update $update, array $data)
    {
        $this->campaign = $update->campaign;
        parent::__construct($update->starteed, "{$update->endpoint}/{$this->id}", $data);
    }
}