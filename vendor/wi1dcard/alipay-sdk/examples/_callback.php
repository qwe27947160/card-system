<?php
 $aop = require __DIR__ . '/_bootstrap.php'; ob_start(); if (php_sapi_name() === 'cli') { parse_str($argv[1], $_POST); } try { $passed = $aop->verify(); } catch (\Exception $ex) { $passed = null; printf('%s | %s' . PHP_EOL, get_class($ex), $ex->getMessage()); } if ($passed) { print_r($params); } $file = fopen('logs/callback.log', 'a'); fwrite($file, date('Y-m-d H:i:s') . PHP_EOL); $content = ob_get_clean(); fwrite($file, $content . PHP_EOL); fclose($file); echo 'success'; 