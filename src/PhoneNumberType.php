<?php

declare(strict_types=1);

namespace Venomousboy\DoctrineStructuresTypes;

use Venomousboy\Structures\PhoneNumber;

final class PhoneNumberType extends WrappedStringType
{
    /**
     * {@inheritdoc}
     */
    protected function getLength(): int
    {
        return 64;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'phone_number';
    }

    protected function isFixed(): bool
    {
        return true;
    }

    protected function getClassName(): string
    {
        return PhoneNumber::class;
    }
}