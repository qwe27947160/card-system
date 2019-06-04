<?php
 namespace Alipay\Request; class AlipayMobilePublicInfoModifyRequest extends AbstractAlipayRequest { private $appName; private $authPic; private $licenseUrl; private $logoUrl; private $publicGreeting; private $shopPic1; private $shopPic2; private $shopPic3; public function setAppName($appName) { $this->appName = $appName; $this->apiParams['app_name'] = $appName; } public function getAppName() { return $this->appName; } public function setAuthPic($authPic) { $this->authPic = $authPic; $this->apiParams['auth_pic'] = $authPic; } public function getAuthPic() { return $this->authPic; } public function setLicenseUrl($licenseUrl) { $this->licenseUrl = $licenseUrl; $this->apiParams['license_url'] = $licenseUrl; } public function getLicenseUrl() { return $this->licenseUrl; } public function setLogoUrl($logoUrl) { $this->logoUrl = $logoUrl; $this->apiParams['logo_url'] = $logoUrl; } public function getLogoUrl() { return $this->logoUrl; } public function setPublicGreeting($publicGreeting) { $this->publicGreeting = $publicGreeting; $this->apiParams['public_greeting'] = $publicGreeting; } public function getPublicGreeting() { return $this->publicGreeting; } public function setShopPic1($shopPic1) { $this->shopPic1 = $shopPic1; $this->apiParams['shop_pic1'] = $shopPic1; } public function getShopPic1() { return $this->shopPic1; } public function setShopPic2($shopPic2) { $this->shopPic2 = $shopPic2; $this->apiParams['shop_pic2'] = $shopPic2; } public function getShopPic2() { return $this->shopPic2; } public function setShopPic3($shopPic3) { $this->shopPic3 = $shopPic3; $this->apiParams['shop_pic3'] = $shopPic3; } public function getShopPic3() { return $this->shopPic3; } } 