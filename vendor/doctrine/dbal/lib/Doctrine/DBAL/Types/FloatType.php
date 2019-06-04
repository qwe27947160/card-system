<?php
 namespace Doctrine\DBAL\Types; use Doctrine\DBAL\Platforms\AbstractPlatform; class FloatType extends Type { public function getName() { return Type::FLOAT; } public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) { return $platform->getFloatDeclarationSQL($fieldDeclaration); } public function convertToPHPValue($value, AbstractPlatform $platform) { return (null === $value) ? null : (double) $value; } } 