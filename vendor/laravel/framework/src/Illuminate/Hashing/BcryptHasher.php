<?php
 namespace Illuminate\Hashing; use RuntimeException; use Illuminate\Contracts\Hashing\Hasher as HasherContract; class BcryptHasher implements HasherContract { protected $rounds = 10; public function make($value, array $options = []) { $hash = password_hash($value, PASSWORD_BCRYPT, [ 'cost' => $this->cost($options), ]); if ($hash === false) { throw new RuntimeException('Bcrypt hashing not supported.'); } return $hash; } public function check($value, $hashedValue, array $options = []) { if (strlen($hashedValue) === 0) { return false; } return password_verify($value, $hashedValue); } public function needsRehash($hashedValue, array $options = []) { return password_needs_rehash($hashedValue, PASSWORD_BCRYPT, [ 'cost' => $this->cost($options), ]); } public function setRounds($rounds) { $this->rounds = (int) $rounds; return $this; } protected function cost(array $options = []) { return $options['rounds'] ?? $this->rounds; } } 