<?php
 namespace Doctrine\DBAL\Event; use Doctrine\DBAL\Platforms\AbstractPlatform; use Doctrine\DBAL\Schema\Table; class SchemaCreateTableEventArgs extends SchemaEventArgs { private $_table; private $_columns; private $_options; private $_platform; private $_sql = array(); public function __construct(Table $table, array $columns, array $options, AbstractPlatform $platform) { $this->_table = $table; $this->_columns = $columns; $this->_options = $options; $this->_platform = $platform; } public function getTable() { return $this->_table; } public function getColumns() { return $this->_columns; } public function getOptions() { return $this->_options; } public function getPlatform() { return $this->_platform; } public function addSql($sql) { if (is_array($sql)) { $this->_sql = array_merge($this->_sql, $sql); } else { $this->_sql[] = $sql; } return $this; } public function getSql() { return $this->_sql; } } 