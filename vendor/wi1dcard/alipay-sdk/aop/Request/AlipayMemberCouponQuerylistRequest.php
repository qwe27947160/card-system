<?php
 namespace Alipay\Request; class AlipayMemberCouponQuerylistRequest extends AbstractAlipayRequest { private $merchantInfo; private $pageNo; private $pageSize; private $status; private $userInfo; public function setMerchantInfo($merchantInfo) { $this->merchantInfo = $merchantInfo; $this->apiParams['merchant_info'] = $merchantInfo; } public function getMerchantInfo() { return $this->merchantInfo; } public function setPageNo($pageNo) { $this->pageNo = $pageNo; $this->apiParams['page_no'] = $pageNo; } public function getPageNo() { return $this->pageNo; } public function setPageSize($pageSize) { $this->pageSize = $pageSize; $this->apiParams['page_size'] = $pageSize; } public function getPageSize() { return $this->pageSize; } public function setStatus($status) { $this->status = $status; $this->apiParams['status'] = $status; } public function getStatus() { return $this->status; } public function setUserInfo($userInfo) { $this->userInfo = $userInfo; $this->apiParams['user_info'] = $userInfo; } public function getUserInfo() { return $this->userInfo; } } 