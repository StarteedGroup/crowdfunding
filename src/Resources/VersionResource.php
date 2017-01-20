<?php

namespace Starteed\Resources;

use Starteed\Crowdfunding;
use Starteed\Resources\ResourceBase;

class VersionResource extends ResourceBase
{
    public function __construct(Crowdfunding $starteed, array $data)
    {
        parent::__construct($starteed, 'versions/' . $data['id'], $data);
        $this->setupEndpoints();
    }

    protected function setupEndpoints()
    {
    	$this->language = new LanguageResource($this, (array) $this->language->data);
    }
}