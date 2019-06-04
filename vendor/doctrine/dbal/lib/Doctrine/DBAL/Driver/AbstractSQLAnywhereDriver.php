<?php
 namespace Doctrine\DBAL\Driver; use Doctrine\DBAL\DBALException; use Doctrine\DBAL\Driver; use Doctrine\DBAL\Exception; use Doctrine\DBAL\Platforms\SQLAnywhere11Platform; use Doctrine\DBAL\Platforms\SQLAnywhere12Platform; use Doctrine\DBAL\Platforms\SQLAnywhere16Platform; use Doctrine\DBAL\Platforms\SQLAnywherePlatform; use Doctrine\DBAL\Schema\SQLAnywhereSchemaManager; use Doctrine\DBAL\VersionAwarePlatformDriver; abstract class AbstractSQLAnywhereDriver implements Driver, ExceptionConverterDriver, VersionAwarePlatformDriver { public function convertException($message, DriverException $exception) { switch ($exception->getErrorCode()) { case '-100': case '-103': case '-832': return new Exception\ConnectionException($message, $exception); case '-143': return new Exception\InvalidFieldNameException($message, $exception); case '-193': case '-196': return new Exception\UniqueConstraintViolationException($message, $exception); case '-194': case '-198': return new Exception\ForeignKeyConstraintViolationException($message, $exception); case '-144': return new Exception\NonUniqueFieldNameException($message, $exception); case '-184': case '-195': return new Exception\NotNullConstraintViolationException($message, $exception); case '-131': return new Exception\SyntaxErrorException($message, $exception); case '-110': return new Exception\TableExistsException($message, $exception); case '-141': case '-1041': return new Exception\TableNotFoundException($message, $exception); } return new Exception\DriverException($message, $exception); } public function createDatabasePlatformForVersion($version) { if ( ! preg_match( '/^(?P<major>\d+)(?:\.(?P<minor>\d+)(?:\.(?P<patch>\d+)(?:\.(?P<build>\d+))?)?)?/', $version, $versionParts )) { throw DBALException::invalidPlatformVersionSpecified( $version, '<major_version>.<minor_version>.<patch_version>.<build_version>' ); } $majorVersion = $versionParts['major']; $minorVersion = isset($versionParts['minor']) ? $versionParts['minor'] : 0; $patchVersion = isset($versionParts['patch']) ? $versionParts['patch'] : 0; $buildVersion = isset($versionParts['build']) ? $versionParts['build'] : 0; $version = $majorVersion . '.' . $minorVersion . '.' . $patchVersion . '.' . $buildVersion; switch(true) { case version_compare($version, '16', '>='): return new SQLAnywhere16Platform(); case version_compare($version, '12', '>='): return new SQLAnywhere12Platform(); case version_compare($version, '11', '>='): return new SQLAnywhere11Platform(); default: return new SQLAnywherePlatform(); } } public function getDatabase(\Doctrine\DBAL\Connection $conn) { $params = $conn->getParams(); if (isset($params['dbname'])) { return $params['dbname']; } return $conn->query('SELECT DB_NAME()')->fetchColumn(); } public function getDatabasePlatform() { return new SQLAnywhere12Platform(); } public function getSchemaManager(\Doctrine\DBAL\Connection $conn) { return new SQLAnywhereSchemaManager($conn); } } 