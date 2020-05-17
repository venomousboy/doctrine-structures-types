<?php

declare(strict_types=1);

namespace Venomousboy\DoctrineStructuresTypes;

use Venomousboy\Structures\WrappedString;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

abstract class WrappedStringType extends Type
{
    abstract protected function isFixed(): bool;

    abstract protected function getClassName(): string;

    abstract protected function getLength(): int;

    final public function getDefaultLength(AbstractPlatform $platform)
    {
        return $this->getLength();
    }

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL(
            array_merge($fieldDeclaration, ['fixed' => $this->isFixed(), 'length' => $this->getLength()])
        );
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof WrappedString) {
            throw new \InvalidArgumentException('Value must be subclsass of ' . WrappedString::class);
        }
        $className = $this->getClassName();
        if (!$value instanceof $className) {
            throw new \InvalidArgumentException('Value must be subclsass of ' . $className);
        }
        return parent::convertToDatabaseValue((string)$value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        $className = $this->getClassName();

        return new $className(parent::convertToPHPValue($value, $platform));
    }
}
