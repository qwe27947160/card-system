<?php
 namespace Alipay\Request; class AlipayMobilePublicTemplateMessageGetRequest extends AbstractAlipayRequest { private $templateId; public function setTemplateId($templateId) { $this->templateId = $templateId; $this->apiParams['template_id'] = $templateId; } public function getTemplateId() { return $this->templateId; } } 