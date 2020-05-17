<?php

declare(strict_types=1);

namespace Venomousboy\DoctrineStructuresTypes;

use Venomousboy\Identity\UuidIdentity;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Doctrine\UuidType;

abstract class UuidIdentityType extends UuidType
{
    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return null | UuidIdentity
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    final public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $class = $this->getIdentityClass();

        $value = parent::convertToPHPValue($value, $platform);

        if (null === $value) {
            return null;
        }

        return new $class($value);
    }

    /**
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    final public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof UuidIdentity) {
            throw new \InvalidArgumentException('Value must be ' . UuidIdentity::class . ' type');
        }

        return parent::convertToDatabaseValue($value->getRawValue(), $platform);
    }

    /**
     * @return string | UuidIdentity
     */
    abstract protected function getIdentityClass(): string;
}