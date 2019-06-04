<?php
 namespace Predis\Configuration; class Options implements OptionsInterface { protected $input; protected $options; protected $handlers; public function __construct(array $options = array()) { $this->input = $options; $this->options = array(); $this->handlers = $this->getHandlers(); } protected function getHandlers() { return array( 'cluster' => 'Predis\Configuration\ClusterOption', 'connections' => 'Predis\Configuration\ConnectionFactoryOption', 'exceptions' => 'Predis\Configuration\ExceptionsOption', 'prefix' => 'Predis\Configuration\PrefixOption', 'profile' => 'Predis\Configuration\ProfileOption', 'replication' => 'Predis\Configuration\ReplicationOption', ); } public function getDefault($option) { if (isset($this->handlers[$option])) { $handler = $this->handlers[$option]; $handler = new $handler(); return $handler->getDefault($this); } } public function defined($option) { return array_key_exists($option, $this->options) || array_key_exists($option, $this->input) ; } public function __isset($option) { return ( array_key_exists($option, $this->options) || array_key_exists($option, $this->input) ) && $this->__get($option) !== null; } public function __get($option) { if (isset($this->options[$option]) || array_key_exists($option, $this->options)) { return $this->options[$option]; } if (isset($this->input[$option]) || array_key_exists($option, $this->input)) { $value = $this->input[$option]; unset($this->input[$option]); if (is_object($value) && method_exists($value, '__invoke')) { $value = $value($this, $option); } if (isset($this->handlers[$option])) { $handler = $this->handlers[$option]; $handler = new $handler(); $value = $handler->filter($this, $value); } return $this->options[$option] = $value; } if (isset($this->handlers[$option])) { return $this->options[$option] = $this->getDefault($option); } return; } } 