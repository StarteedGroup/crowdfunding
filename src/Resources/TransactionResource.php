<?php

namespace Starteed\Resources;

use Starteed\Transaction;
use Starteed\Resources\ResourceBase;

class TransactionResource extends ResourceBase
{
    public function __construct(Transaction $transaction, array $data)
    {
        $this->resource = json_decode(json_encode($data));
        parent::__construct($transaction->starteed, "{$transaction->endpoint}/{$this->id}");
    }

    public function __get($property)
    {
        if (property_exists($this->resource, $property)) {
          return $this->resource->$property;
        }
    }
}