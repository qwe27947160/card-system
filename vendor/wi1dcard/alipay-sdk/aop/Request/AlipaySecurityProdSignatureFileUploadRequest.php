<?php
 namespace Alipay\Request; class AlipaySecurityProdSignatureFileUploadRequest extends AbstractAlipayRequest { private $bizProduct; private $fileContent; public function setBizProduct($bizProduct) { $this->bizProduct = $bizProduct; $this->apiParams['biz_product'] = $bizProduct; } public function getBizProduct() { return $this->bizProduct; } public function setFileContent($fileContent) { $this->fileContent = $fileContent; $this->apiParams['file_content'] = $fileContent; } public function getFileContent() { return $this->fileContent; } } 