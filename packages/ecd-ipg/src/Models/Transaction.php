<?php

namespace Bahramn\EcdIpg\Models;

use Bahramn\EcdIpg\Traits\Payable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string        status
 * @property float         amount
 * @property string        gateway
 * @property string        currency
 * @property string        uuid
 * @property string|null   rrn
 * @property string|null   stan
 * @property Model|Payable payable
 * @property string|null   message
 * @property array|null    requests
 *
 * @package Bahramn\EcdIpg\Models
 */
class Transaction extends Model
{
    const STATUS_NEW = 'new';
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELED = 'canceled';
    const STATUS_INITIALIZATION_FAILED = 'initialization-failed';
    const STATUS_VERIFICATION_FAILED = 'verification-failed';

    protected $fillable = ['status', 'amount', 'gateway', 'currency', 'uuid', 'stan', 'rrn'];

    public function payable(): MorphTo
    {
        return $this->morphTo();
    }

}
