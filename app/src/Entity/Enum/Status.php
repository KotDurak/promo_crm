<?php

namespace App\Entity\Enum;

enum Status: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case CANCELLED = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::PAID => 'Выплачено',
            self::CANCELLED => 'Отменено',
            self::PENDING => 'Ожидает рассмотрения'
        };
    }

    public function isPending(): bool
    {
        return $this === self::PENDING;
    }

    public static function getListForSelect(): array
    {
        return  [
            self::PENDING->value => self::PENDING->getLabel(),
            self::PAID->value => self::PAID->getLabel(),
            self::CANCELLED->value => self::CANCELLED->getLabel(),
        ];
    }
}
