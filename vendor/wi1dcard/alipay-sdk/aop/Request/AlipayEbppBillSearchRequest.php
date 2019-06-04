<?php
 namespace Alipay\Request; class AlipayEbppBillSearchRequest extends AbstractAlipayRequest { private $billKey; private $chargeInst; private $chargeoffInst; private $companyId; private $extend; private $orderType; private $subOrderType; public function setBillKey($billKey) { $this->billKey = $billKey; $this->apiParams['bill_key'] = $billKey; } public function getBillKey() { return $this->billKey; } public function setChargeInst($chargeInst) { $this->chargeInst = $chargeInst; $this->apiParams['charge_inst'] = $chargeInst; } public function getChargeInst() { return $this->chargeInst; } public function setChargeoffInst($chargeoffInst) { $this->chargeoffInst = $chargeoffInst; $this->apiParams['chargeoff_inst'] = $chargeoffInst; } public function getChargeoffInst() { return $this->chargeoffInst; } public function setCompanyId($companyId) { $this->companyId = $companyId; $this->apiParams['company_id'] = $companyId; } public function getCompanyId() { return $this->companyId; } public function setExtend($extend) { $this->extend = $extend; $this->apiParams['extend'] = $extend; } public function getExtend() { return $this->extend; } public function setOrderType($orderType) { $this->orderType = $orderType; $this->apiParams['order_type'] = $orderType; } public function getOrderType() { return $this->orderType; } public function setSubOrderType($subOrderType) { $this->subOrderType = $subOrderType; $this->apiParams['sub_order_type'] = $subOrderType; } public function getSubOrderType() { return $this->subOrderType; } } 