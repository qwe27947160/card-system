<?php
 namespace Alipay\Request; class AlipayEbppPdeductPayRequest extends AbstractAlipayRequest { private $agentChannel; private $agentCode; private $agreementId; private $billDate; private $billKey; private $extendField; private $fineAmount; private $memo; private $outOrderNo; private $payAmount; private $pid; private $userId; public function setAgentChannel($agentChannel) { $this->agentChannel = $agentChannel; $this->apiParams['agent_channel'] = $agentChannel; } public function getAgentChannel() { return $this->agentChannel; } public function setAgentCode($agentCode) { $this->agentCode = $agentCode; $this->apiParams['agent_code'] = $agentCode; } public function getAgentCode() { return $this->agentCode; } public function setAgreementId($agreementId) { $this->agreementId = $agreementId; $this->apiParams['agreement_id'] = $agreementId; } public function getAgreementId() { return $this->agreementId; } public function setBillDate($billDate) { $this->billDate = $billDate; $this->apiParams['bill_date'] = $billDate; } public function getBillDate() { return $this->billDate; } public function setBillKey($billKey) { $this->billKey = $billKey; $this->apiParams['bill_key'] = $billKey; } public function getBillKey() { return $this->billKey; } public function setExtendField($extendField) { $this->extendField = $extendField; $this->apiParams['extend_field'] = $extendField; } public function getExtendField() { return $this->extendField; } public function setFineAmount($fineAmount) { $this->fineAmount = $fineAmount; $this->apiParams['fine_amount'] = $fineAmount; } public function getFineAmount() { return $this->fineAmount; } public function setMemo($memo) { $this->memo = $memo; $this->apiParams['memo'] = $memo; } public function getMemo() { return $this->memo; } public function setOutOrderNo($outOrderNo) { $this->outOrderNo = $outOrderNo; $this->apiParams['out_order_no'] = $outOrderNo; } public function getOutOrderNo() { return $this->outOrderNo; } public function setPayAmount($payAmount) { $this->payAmount = $payAmount; $this->apiParams['pay_amount'] = $payAmount; } public function getPayAmount() { return $this->payAmount; } public function setPid($pid) { $this->pid = $pid; $this->apiParams['pid'] = $pid; } public function getPid() { return $this->pid; } public function setUserId($userId) { $this->userId = $userId; $this->apiParams['user_id'] = $userId; } public function getUserId() { return $this->userId; } } 