<?php
 namespace Alipay\Request; class AlipayOperatorMobileBindRequest extends AbstractAlipayRequest { private $checkSigncard; private $fReturnUrl; private $hasSpi; private $operatorName; private $provinceName; private $sReturnUrl; public function setCheckSigncard($checkSigncard) { $this->checkSigncard = $checkSigncard; $this->apiParams['check_signcard'] = $checkSigncard; } public function getCheckSigncard() { return $this->checkSigncard; } public function setfReturnUrl($fReturnUrl) { $this->fReturnUrl = $fReturnUrl; $this->apiParams['f_return_url'] = $fReturnUrl; } public function getfReturnUrl() { return $this->fReturnUrl; } public function setHasSpi($hasSpi) { $this->hasSpi = $hasSpi; $this->apiParams['has_spi'] = $hasSpi; } public function getHasSpi() { return $this->hasSpi; } public function setOperatorName($operatorName) { $this->operatorName = $operatorName; $this->apiParams['operator_name'] = $operatorName; } public function getOperatorName() { return $this->operatorName; } public function setProvinceName($provinceName) { $this->provinceName = $provinceName; $this->apiParams['province_name'] = $provinceName; } public function getProvinceName() { return $this->provinceName; } public function setsReturnUrl($sReturnUrl) { $this->sReturnUrl = $sReturnUrl; $this->apiParams['s_return_url'] = $sReturnUrl; } public function getsReturnUrl() { return $this->sReturnUrl; } } 