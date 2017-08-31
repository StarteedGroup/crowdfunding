<?php

namespace Starteed;

abstract class BaseResource
{
    /**
     * @var array
     */
    protected $original;

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = json_decode(json_encode($value));
        }
        $this->original = $data;
    }
}