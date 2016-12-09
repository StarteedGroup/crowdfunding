<?php

namespace Starteed\Resources;

use Starteed\Transaction;
use Starteed\Resources\ResourceBase;

class TransactionResource extends ResourceBase
{
    public function __construct(Transaction $transaction, array $data)
    {
        parent::__construct($transaction->starteed, $transaction->endpoint . '/' . $data['id'], $data);
    }

    public function share(array $emails)
    {
        return parent::request('POST', 'share', ['emails' => $emails], [])->getBody();
    }
}