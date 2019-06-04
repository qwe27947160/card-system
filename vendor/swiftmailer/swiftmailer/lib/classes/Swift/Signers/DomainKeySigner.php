<?php
 class Swift_Signers_DomainKeySigner implements Swift_Signers_HeaderSigner { protected $privateKey; protected $domainName; protected $selector; protected $hashAlgorithm = 'rsa-sha1'; protected $canon = 'simple'; protected $ignoredHeaders = []; protected $signerIdentity; protected $debugHeaders = false; private $signedHeaders = []; protected $domainKeyHeader; private $hashHandler; private $canonData = ''; private $bodyCanonEmptyCounter = 0; private $bodyCanonIgnoreStart = 2; private $bodyCanonSpace = false; private $bodyCanonLastChar = null; private $bodyCanonLine = ''; private $bound = []; public function __construct($privateKey, $domainName, $selector) { $this->privateKey = $privateKey; $this->domainName = $domainName; $this->signerIdentity = '@'.$domainName; $this->selector = $selector; } public function reset() { $this->hashHandler = null; $this->bodyCanonIgnoreStart = 2; $this->bodyCanonEmptyCounter = 0; $this->bodyCanonLastChar = null; $this->bodyCanonSpace = false; return $this; } public function write($bytes) { $this->canonicalizeBody($bytes); foreach ($this->bound as $is) { $is->write($bytes); } return $this; } public function commit() { return $this; } public function bind(Swift_InputByteStream $is) { $this->bound[] = $is; return $this; } public function unbind(Swift_InputByteStream $is) { foreach ($this->bound as $k => $stream) { if ($stream === $is) { unset($this->bound[$k]); break; } } return $this; } public function flushBuffers() { $this->reset(); return $this; } public function setHashAlgorithm($hash) { $this->hashAlgorithm = 'rsa-sha1'; return $this; } public function setCanon($canon) { if ('nofws' == $canon) { $this->canon = 'nofws'; } else { $this->canon = 'simple'; } return $this; } public function setSignerIdentity($identity) { $this->signerIdentity = $identity; return $this; } public function setDebugHeaders($debug) { $this->debugHeaders = (bool) $debug; return $this; } public function startBody() { } public function endBody() { $this->endOfBody(); } public function getAlteredHeaders() { if ($this->debugHeaders) { return ['DomainKey-Signature', 'X-DebugHash']; } return ['DomainKey-Signature']; } public function ignoreHeader($header_name) { $this->ignoredHeaders[strtolower($header_name)] = true; return $this; } public function setHeaders(Swift_Mime_SimpleHeaderSet $headers) { $this->startHash(); $this->canonData = ''; $listHeaders = $headers->listAll(); foreach ($listHeaders as $hName) { if (!isset($this->ignoredHeaders[strtolower($hName)])) { if ($headers->has($hName)) { $tmp = $headers->getAll($hName); foreach ($tmp as $header) { if ('' != $header->getFieldBody()) { $this->addHeader($header->toString()); $this->signedHeaders[] = $header->getFieldName(); } } } } } $this->endOfHeaders(); return $this; } public function addSignature(Swift_Mime_SimpleHeaderSet $headers) { $params = ['a' => $this->hashAlgorithm, 'b' => chunk_split(base64_encode($this->getEncryptedHash()), 73, ' '), 'c' => $this->canon, 'd' => $this->domainName, 'h' => implode(': ', $this->signedHeaders), 'q' => 'dns', 's' => $this->selector]; $string = ''; foreach ($params as $k => $v) { $string .= $k.'='.$v.'; '; } $string = trim($string); $headers->addTextHeader('DomainKey-Signature', $string); return $this; } protected function addHeader($header) { switch ($this->canon) { case 'nofws': $exploded = explode(':', $header, 2); $name = strtolower(trim($exploded[0])); $value = str_replace("\r\n", '', $exploded[1]); $value = preg_replace("/[ \t][ \t]+/", ' ', $value); $header = $name.':'.trim($value)."\r\n"; case 'simple': } $this->addToHash($header); } protected function endOfHeaders() { $this->bodyCanonEmptyCounter = 1; } protected function canonicalizeBody($string) { $len = strlen($string); $canon = ''; $nofws = ('nofws' == $this->canon); for ($i = 0; $i < $len; ++$i) { if ($this->bodyCanonIgnoreStart > 0) { --$this->bodyCanonIgnoreStart; continue; } switch ($string[$i]) { case "\r": $this->bodyCanonLastChar = "\r"; break; case "\n": if ("\r" == $this->bodyCanonLastChar) { if ($nofws) { $this->bodyCanonSpace = false; } if ('' == $this->bodyCanonLine) { ++$this->bodyCanonEmptyCounter; } else { $this->bodyCanonLine = ''; $canon .= "\r\n"; } } else { throw new Swift_SwiftException('Invalid new line sequence in mail found \n without preceding \r'); } break; case ' ': case "\t": case "\x09": if ($nofws) { $this->bodyCanonSpace = true; break; } default: if ($this->bodyCanonEmptyCounter > 0) { $canon .= str_repeat("\r\n", $this->bodyCanonEmptyCounter); $this->bodyCanonEmptyCounter = 0; } $this->bodyCanonLine .= $string[$i]; $canon .= $string[$i]; } } $this->addToHash($canon); } protected function endOfBody() { if (strlen($this->bodyCanonLine) > 0) { $this->addToHash("\r\n"); } } private function addToHash($string) { $this->canonData .= $string; hash_update($this->hashHandler, $string); } private function startHash() { switch ($this->hashAlgorithm) { case 'rsa-sha1': $this->hashHandler = hash_init('sha1'); break; } $this->bodyCanonLine = ''; } private function getEncryptedHash() { $signature = ''; $pkeyId = openssl_get_privatekey($this->privateKey); if (!$pkeyId) { throw new Swift_SwiftException('Unable to load DomainKey Private Key ['.openssl_error_string().']'); } if (openssl_sign($this->canonData, $signature, $pkeyId, OPENSSL_ALGO_SHA1)) { return $signature; } throw new Swift_SwiftException('Unable to sign DomainKey Hash  ['.openssl_error_string().']'); } } 