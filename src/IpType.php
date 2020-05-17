<?php

declare(strict_types=1);

namespace Venomousboy\DoctrineStructuresTypes;

use Venomousboy\Structures\Ip;

final class IpType extends WrappedStringType
{
    protected function getLength(): int
    {
        return 45;
    }

    public function getName()
    {
        return 'ip';
    }

    protected function isFixed(): bool
    {
        return false;
    }

    protected function getClassName(): string
    {
        return Ip::class;
    }
}