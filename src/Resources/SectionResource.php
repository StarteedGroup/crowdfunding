<?php

namespace Starteed\Resources;

use Starteed\Crowdfunding;
use Starteed\Resources\ResourceBase;

class SectionResource extends ResourceBase
{
    public function __construct(Crowdfunding $starteed, array $data)
    {
        parent::__construct($starteed, 'sections', $data);
        $this->setupEndpoints();
    }

    private function setupEndpoints()
    {
        //
    }
}