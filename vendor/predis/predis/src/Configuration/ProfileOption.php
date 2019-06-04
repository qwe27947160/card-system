<?php
 namespace Predis\Configuration; use Predis\Profile\Factory; use Predis\Profile\ProfileInterface; use Predis\Profile\RedisProfile; class ProfileOption implements OptionInterface { protected function setProcessors(OptionsInterface $options, ProfileInterface $profile) { if (isset($options->prefix) && $profile instanceof RedisProfile) { $profile->setProcessor($options->__get('prefix')); } } public function filter(OptionsInterface $options, $value) { if (is_string($value)) { $value = Factory::get($value); $this->setProcessors($options, $value); } elseif (!$value instanceof ProfileInterface) { throw new \InvalidArgumentException('Invalid value for the profile option.'); } return $value; } public function getDefault(OptionsInterface $options) { $profile = Factory::getDefault(); $this->setProcessors($options, $profile); return $profile; } } 