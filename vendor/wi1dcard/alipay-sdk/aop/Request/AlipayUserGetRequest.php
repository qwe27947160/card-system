<?php
 namespace Alipay\Request; class AlipayUserGetRequest extends AbstractAlipayRequest { private $fields; public function setFields($fields) { $this->fields = $fields; $this->apiParams['fields'] = $fields; } public function getFields() { return $this->fields; } } 