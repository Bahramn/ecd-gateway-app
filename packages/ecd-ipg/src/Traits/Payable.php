<?php

namespace Bahramn\EcdIpg\Traits;

use Bahramn\EcdIpg\Models\Transaction;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Payable
{
    public abstract function amount(): float;

    public abstract function currency(): string;

    public abstract function getUniqueId(): string;

    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'payable');
    }
}
