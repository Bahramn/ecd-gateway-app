<?php

namespace Bahramn\EcdIpg\Traits;

use Illuminate\Log\Logger;

/**
 * @package Bahramn\EcdIpg\Traits
 */
trait Loggable
{
    protected function log(string $message, array $context = [], bool $enabled = true): void
    {
        if (isset($this->logger) && $enabled) {
            $this->logger->info($message, $context);
        }
    }
}
