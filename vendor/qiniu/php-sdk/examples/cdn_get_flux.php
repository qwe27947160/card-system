<?php
 require_once __DIR__ . '/../autoload.php'; use \Qiniu\Cdn\CdnManager; $accessKey = getenv('QINIU_ACCESS_KEY'); $secretKey = getenv('QINIU_SECRET_KEY'); $auth = new Qiniu\Auth($accessKey, $secretKey); $cdnManager = new CdnManager($auth); $domains = array( "javasdk.qiniudn.com", "phpsdk.qiniudn.com" ); $startDate = "2017-08-20"; $endDate = "2017-08-21"; $granularity = "day"; list($fluxData, $getFluxErr) = $cdnManager->getFluxData($domains, $startDate, $endDate, $granularity); if ($getFluxErr != null) { var_dump($getFluxErr); } else { echo "get flux data success\n"; print_r($fluxData); } 