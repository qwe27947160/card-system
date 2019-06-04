<?php
 namespace Alipay\Request; class AlipayPointOrderGetRequest extends AbstractAlipayRequest { private $merchantOrderNo; private $userSymbol; private $userSymbolType; public function setMerchantOrderNo($merchantOrderNo) { $this->merchantOrderNo = $merchantOrderNo; $this->apiParams['merchant_order_no'] = $merchantOrderNo; } public function getMerchantOrderNo() { return $this->merchantOrderNo; } public function setUserSymbol($userSymbol) { $this->userSymbol = $userSymbol; $this->apiParams['user_symbol'] = $userSymbol; } public function getUserSymbol() { return $this->userSymbol; } public function setUserSymbolType($userSymbolType) { $this->userSymbolType = $userSymbolType; $this->apiParams['user_symbol_type'] = $userSymbolType; } public function getUserSymbolType() { return $this->userSymbolType; } } 