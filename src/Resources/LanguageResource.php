<?php

namespace Starteed\Resources;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\VersionResource;

class LanguageResource extends ResourceBase
{
    public function __construct(VersionResource $version, array $data)
    {
        parent::__construct($version->starteed, '', $data);
    }
}