<?php

declare(strict_types=1);

namespace Venomousboy\DoctrineStructuresTypes;

use Venomousboy\Structures\Email;

final class EmailType extends WrappedStringType
{
    protected function getLength(): int
    {
        return 255;
    }

    public function getName()
    {
        return 'email';
    }

    protected function isFixed(): bool
    {
        return false;
    }

    protected function getClassName(): string
    {
        return Email::class;
    }
}