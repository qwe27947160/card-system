<?php
 namespace Alipay\Request; class AlipayOpenPublicLifeCreateRequest extends AbstractAlipayRequest { private $background; private $contactEmail; private $contactName; private $contactTel; private $customerTel; private $description; private $extendData; private $lifeName; private $logo; private $mccCode; private $publicBizType; private $showStyle; private $userId; public function setBackground($background) { $this->background = $background; $this->apiParams['background'] = $background; } public function getBackground() { return $this->background; } public function setContactEmail($contactEmail) { $this->contactEmail = $contactEmail; $this->apiParams['contact_email'] = $contactEmail; } public function getContactEmail() { return $this->contactEmail; } public function setContactName($contactName) { $this->contactName = $contactName; $this->apiParams['contact_name'] = $contactName; } public function getContactName() { return $this->contactName; } public function setContactTel($contactTel) { $this->contactTel = $contactTel; $this->apiParams['contact_tel'] = $contactTel; } public function getContactTel() { return $this->contactTel; } public function setCustomerTel($customerTel) { $this->customerTel = $customerTel; $this->apiParams['customer_tel'] = $customerTel; } public function getCustomerTel() { return $this->customerTel; } public function setDescription($description) { $this->description = $description; $this->apiParams['description'] = $description; } public function getDescription() { return $this->description; } public function setExtendData($extendData) { $this->extendData = $extendData; $this->apiParams['extend_data'] = $extendData; } public function getExtendData() { return $this->extendData; } public function setLifeName($lifeName) { $this->lifeName = $lifeName; $this->apiParams['life_name'] = $lifeName; } public function getLifeName() { return $this->lifeName; } public function setLogo($logo) { $this->logo = $logo; $this->apiParams['logo'] = $logo; } public function getLogo() { return $this->logo; } public function setMccCode($mccCode) { $this->mccCode = $mccCode; $this->apiParams['mcc_code'] = $mccCode; } public function getMccCode() { return $this->mccCode; } public function setPublicBizType($publicBizType) { $this->publicBizType = $publicBizType; $this->apiParams['public_biz_type'] = $publicBizType; } public function getPublicBizType() { return $this->publicBizType; } public function setShowStyle($showStyle) { $this->showStyle = $showStyle; $this->apiParams['show_style'] = $showStyle; } public function getShowStyle() { return $this->showStyle; } public function setUserId($userId) { $this->userId = $userId; $this->apiParams['user_id'] = $userId; } public function getUserId() { return $this->userId; } } 