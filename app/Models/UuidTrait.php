<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;

trait UuidTrait
{
    /**
     * @throws \Exception
     */
    protected static function bootUuidTrait() {
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->uuid = Uuid::uuid4()->toString();
            }
        });
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }
}
