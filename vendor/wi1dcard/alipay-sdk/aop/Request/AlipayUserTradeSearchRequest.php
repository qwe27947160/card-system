<?php
 namespace Alipay\Request; class AlipayUserTradeSearchRequest extends AbstractAlipayRequest { private $alipayOrderNo; private $endTime; private $merchantOrderNo; private $orderFrom; private $orderStatus; private $orderType; private $pageNo; private $pageSize; private $startTime; public function setAlipayOrderNo($alipayOrderNo) { $this->alipayOrderNo = $alipayOrderNo; $this->apiParams['alipay_order_no'] = $alipayOrderNo; } public function getAlipayOrderNo() { return $this->alipayOrderNo; } public function setEndTime($endTime) { $this->endTime = $endTime; $this->apiParams['end_time'] = $endTime; } public function getEndTime() { return $this->endTime; } public function setMerchantOrderNo($merchantOrderNo) { $this->merchantOrderNo = $merchantOrderNo; $this->apiParams['merchant_order_no'] = $merchantOrderNo; } public function getMerchantOrderNo() { return $this->merchantOrderNo; } public function setOrderFrom($orderFrom) { $this->orderFrom = $orderFrom; $this->apiParams['order_from'] = $orderFrom; } public function getOrderFrom() { return $this->orderFrom; } public function setOrderStatus($orderStatus) { $this->orderStatus = $orderStatus; $this->apiParams['order_status'] = $orderStatus; } public function getOrderStatus() { return $this->orderStatus; } public function setOrderType($orderType) { $this->orderType = $orderType; $this->apiParams['order_type'] = $orderType; } public function getOrderType() { return $this->orderType; } public function setPageNo($pageNo) { $this->pageNo = $pageNo; $this->apiParams['page_no'] = $pageNo; } public function getPageNo() { return $this->pageNo; } public function setPageSize($pageSize) { $this->pageSize = $pageSize; $this->apiParams['page_size'] = $pageSize; } public function getPageSize() { return $this->pageSize; } public function setStartTime($startTime) { $this->startTime = $startTime; $this->apiParams['start_time'] = $startTime; } public function getStartTime() { return $this->startTime; } } 