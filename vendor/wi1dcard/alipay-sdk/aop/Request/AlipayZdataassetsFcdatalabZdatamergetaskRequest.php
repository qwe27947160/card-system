<?php
 namespace Alipay\Request; class AlipayZdataassetsFcdatalabZdatamergetaskRequest extends AbstractAlipayRequest { private $bizContent; public function setBizContent($bizContent) { $this->bizContent = $bizContent; $this->apiParams['biz_content'] = $bizContent; } public function getBizContent() { return $this->bizContent; } } 