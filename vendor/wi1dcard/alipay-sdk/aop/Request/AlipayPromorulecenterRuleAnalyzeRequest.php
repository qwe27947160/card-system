<?php
 namespace Alipay\Request; class AlipayPromorulecenterRuleAnalyzeRequest extends AbstractAlipayRequest { private $bizId; private $ruleUuid; private $userId; public function setBizId($bizId) { $this->bizId = $bizId; $this->apiParams['biz_id'] = $bizId; } public function getBizId() { return $this->bizId; } public function setRuleUuid($ruleUuid) { $this->ruleUuid = $ruleUuid; $this->apiParams['rule_uuid'] = $ruleUuid; } public function getRuleUuid() { return $this->ruleUuid; } public function setUserId($userId) { $this->userId = $userId; $this->apiParams['user_id'] = $userId; } public function getUserId() { return $this->userId; } } 