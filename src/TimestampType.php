<?php

declare(strict_types=1);

namespace Venomousboy\DoctrineStructuresTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class TimestampType extends Type
{
    public function getName()
    {
        return 'timestamp';
    }

    final public function getDefaultLength(AbstractPlatform $platform)
    {
        return 10;
    }

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getIntegerTypeDeclarationSQL(
            array_merge($fieldDeclaration, ['length' => $this->getDefaultLength($platform)])
        );
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof \DateTimeImmutable) {
            throw new \InvalidArgumentException('Value must be an instance of ' . \DateTimeImmutable::class);
        }

        return parent::convertToDatabaseValue((string) $value->getTimestamp(), $platform);
    }

    /**
     * @return \DateTimeImmutable|mixed|null
     * @throws \Exception
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        return new \DateTimeImmutable('@' . parent::convertToPHPValue($value, $platform));
    }
}
