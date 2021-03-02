<?php

namespace App\Models;

use Bahramn\EcdIpg\Traits\Payable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property float total_amount
 * @property string uuid
 * @property string status
 */
class Invoice extends Model
{
    use Payable;

    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_FAILED = 'failed';
    const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_PAID,
        self::STATUS_FAILED,
    ];

    protected $fillable = ['status', 'total_amount', 'uuid'];

    public function amount(): float
    {
        return (float) $this->total_amount;
    }

    public function currency(): string
    {
        return 'IRR';
    }

    public function getUniqueId(): string
    {
        return $this->uuid;
    }
}
