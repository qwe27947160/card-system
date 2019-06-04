<?php
 namespace Alipay\Request; class AlipayPassSyncUpdateRequest extends AbstractAlipayRequest { private $channelId; private $extInfo; private $pass; private $serialNumber; private $status; private $verifyCode; private $verifyType; public function setChannelId($channelId) { $this->channelId = $channelId; $this->apiParams['channel_id'] = $channelId; } public function getChannelId() { return $this->channelId; } public function setExtInfo($extInfo) { $this->extInfo = $extInfo; $this->apiParams['ext_info'] = $extInfo; } public function getExtInfo() { return $this->extInfo; } public function setPass($pass) { $this->pass = $pass; $this->apiParams['pass'] = $pass; } public function getPass() { return $this->pass; } public function setSerialNumber($serialNumber) { $this->serialNumber = $serialNumber; $this->apiParams['serial_number'] = $serialNumber; } public function getSerialNumber() { return $this->serialNumber; } public function setStatus($status) { $this->status = $status; $this->apiParams['status'] = $status; } public function getStatus() { return $this->status; } public function setVerifyCode($verifyCode) { $this->verifyCode = $verifyCode; $this->apiParams['verify_code'] = $verifyCode; } public function getVerifyCode() { return $this->verifyCode; } public function setVerifyType($verifyType) { $this->verifyType = $verifyType; $this->apiParams['verify_type'] = $verifyType; } public function getVerifyType() { return $this->verifyType; } } 