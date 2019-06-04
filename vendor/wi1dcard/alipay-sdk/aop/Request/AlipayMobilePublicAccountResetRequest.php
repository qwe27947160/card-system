<?php
 namespace Alipay\Request; class AlipayMobilePublicAccountResetRequest extends AbstractAlipayRequest { private $agreementId; private $bindAccountNo; private $bizContent; private $displayName; private $fromUserId; private $realName; public function setAgreementId($agreementId) { $this->agreementId = $agreementId; $this->apiParams['agreement_id'] = $agreementId; } public function getAgreementId() { return $this->agreementId; } public function setBindAccountNo($bindAccountNo) { $this->bindAccountNo = $bindAccountNo; $this->apiParams['bind_account_no'] = $bindAccountNo; } public function getBindAccountNo() { return $this->bindAccountNo; } public function setBizContent($bizContent) { $this->bizContent = $bizContent; $this->apiParams['biz_content'] = $bizContent; } public function getBizContent() { return $this->bizContent; } public function setDisplayName($displayName) { $this->displayName = $displayName; $this->apiParams['display_name'] = $displayName; } public function getDisplayName() { return $this->displayName; } public function setFromUserId($fromUserId) { $this->fromUserId = $fromUserId; $this->apiParams['from_user_id'] = $fromUserId; } public function getFromUserId() { return $this->fromUserId; } public function setRealName($realName) { $this->realName = $realName; $this->apiParams['real_name'] = $realName; } public function getRealName() { return $this->realName; } } 