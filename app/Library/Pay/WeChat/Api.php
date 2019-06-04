<?php
namespace App\Library\Pay\WeChat; use App\Library\CurlRequest; use App\Library\Helper; use App\Library\Pay\ApiInterface; use Illuminate\Support\Facades\Log; class Api implements ApiInterface { private $url_notify = ''; private $url_return = ''; public function __construct($spf46c5d) { $this->url_notify = SYS_URL_API . '/pay/notify/' . $spf46c5d; $this->url_return = SYS_URL . '/pay/return/' . $spf46c5d; } function goPay($spa9e109, $sp206d07, $sp89af34, $sp92f0c1, $sp28f24f) { $sp9a8a75 = $sp28f24f; $sp651d92 = strtoupper($spa9e109['payway']); if (strpos(@$_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) { $sp651d92 = 'JSAPI'; $sp3bdd6f = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://{$_SERVER['HTTP_HOST']}" . '/pay/' . $sp206d07; $sp8ef900 = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $spa9e109['APPID'] . '&redirect_uri=' . urlencode($sp3bdd6f) . '&response_type=code&scope=snsapi_base#wechat_redirect'; if (!isset($_GET['code'])) { header('Location: ' . $sp8ef900); die; } $sp0ed8f4 = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $spa9e109['APPID'] . '&secret=' . $spa9e109['APPSECRET'] . '&code=' . $_GET['code'] . '&grant_type=authorization_code'; $sp5780b9 = @json_decode(CurlRequest::get($sp0ed8f4), true); if (!$sp5780b9 || !isset($sp5780b9['openid'])) { if (isset($sp5780b9['errcode']) && $sp5780b9['errcode'] === 40163) { header('Location: ' . $sp8ef900); die; } die('<h1>获取微信OPENID<br>错误信息: ' . (isset($sp5780b9['errcode']) ? $sp5780b9['errcode'] : $sp5780b9) . '<br>' . (isset($sp5780b9['errmsg']) ? $sp5780b9['errmsg'] : $sp5780b9) . '<br>请返回重试</h1>'); } $sp4d6482 = $sp5780b9['openid']; } else { if ($sp651d92 === 'JSAPI') { $sp3bdd6f = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://{$_SERVER['HTTP_HOST']}" . '/pay/' . $sp206d07; header('Location: /qrcode/pay/' . $sp206d07 . '/wechat?url=' . urlencode($sp3bdd6f)); die; } } $this->defineWxConfig($spa9e109); require_once __DIR__ . '/lib/WxPay.Api.php'; require_once 'WxPay.NativePay.php'; require_once 'WxLog.php'; $sp390b71 = new \NativePay(); $spd2b050 = new \WxPayUnifiedOrder(); $spd2b050->SetBody($sp89af34); $spd2b050->SetAttach($sp206d07); $spd2b050->SetOut_trade_no($sp206d07); $spd2b050->SetTotal_fee($sp9a8a75); $spd2b050->SetTime_start(date('YmdHis')); $spd2b050->SetTime_expire(date('YmdHis', time() + 600)); $spd2b050->SetGoods_tag('pay'); $spd2b050->SetNotify_url($this->url_notify); $spd2b050->SetTrade_type($sp651d92); if ($sp651d92 === 'MWEB') { $spd2b050->SetScene_info('{"h5_info": {"type":"Wap","wap_url": "' . SYS_URL . '","wap_name": "发卡平台"}}'); } if ($sp651d92 === 'JSAPI') { $spd2b050->SetOpenid($sp4d6482); } $spd2b050->SetProduct_id($sp206d07); $spd2b050->SetSpbill_create_ip(Helper::getIP()); $sp9610ab = $sp390b71->unifiedOrder($spd2b050); function getValue($sp206d07, $sp9610ab, $spf74fd0) { if (!isset($sp9610ab[$spf74fd0])) { Log::error('Pay.WeChat.goPay, order_no:' . $sp206d07 . ', error:' . json_encode($sp9610ab)); if (isset($sp9610ab['err_code_des'])) { throw new \Exception($sp9610ab['err_code_des']); } if (isset($sp9610ab['return_msg'])) { throw new \Exception($sp9610ab['return_msg']); } throw new \Exception('获取支付数据失败'); } return $sp9610ab[$spf74fd0]; } if ($sp651d92 === 'NATIVE') { $sp11a0e0 = getValue($sp206d07, $sp9610ab, 'code_url'); header('Location: /qrcode/pay/' . $sp206d07 . '/wechat?url=' . urlencode($sp11a0e0)); } elseif ($sp651d92 === 'JSAPI') { $sp20678b = array('appId' => $spa9e109['APPID'], 'timeStamp' => strval(time()), 'nonceStr' => md5(time() . 'nonceStr'), 'package' => 'prepay_id=' . getValue($sp206d07, $sp9610ab, 'prepay_id'), 'signType' => 'MD5'); $sp29e0c7 = new \WxPayJsApiPay(); $sp29e0c7->FromArray($sp20678b); $sp20678b['paySign'] = $sp29e0c7->MakeSign(); header('Location: /qrcode/pay/' . $sp206d07 . '/wechat?url=' . urlencode(json_encode($sp20678b))); } elseif ($sp651d92 === 'MWEB') { $sp11a0e0 = getValue($sp206d07, $sp9610ab, 'mweb_url'); $sp931358 = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://{$_SERVER['HTTP_HOST']}" . '/qrcode/pay/' . $sp206d07 . '/wechat?url=query'; echo view('utils.redirect', array('url' => $sp11a0e0 . '&redirect_url=' . urlencode($sp931358))); } die; } private function defineWxConfig($spa9e109) { if (!defined('wx_APPID')) { define('wx_APPID', $spa9e109['APPID']); } if (!defined('wx_MCHID')) { define('wx_MCHID', $spa9e109['MCHID']); } if (!defined('wx_KEY')) { define('wx_KEY', $spa9e109['KEY']); } if (!defined('wx_APPSECRET')) { define('wx_APPSECRET', $spa9e109['APPSECRET']); } } function verify($spa9e109, $spf8927a) { $spf53f48 = isset($spa9e109['isNotify']) && $spa9e109['isNotify']; $this->defineWxConfig($spa9e109); require_once __DIR__ . '/lib/WxPay.Api.php'; require_once 'WxLog.php'; if ($spf53f48) { return (new PayNotifyCallBack($spf8927a))->Handle(false); } else { $sp206d07 = @$spa9e109['out_trade_no']; $spd2b050 = new \WxPayOrderQuery(); $spd2b050->SetOut_trade_no($sp206d07); $sp9610ab = \WxPayApi::orderQuery($spd2b050); if (array_key_exists('trade_state', $sp9610ab) && $sp9610ab['trade_state'] == 'SUCCESS') { call_user_func_array($spf8927a, array($sp9610ab['out_trade_no'], $sp9610ab['total_fee'], $sp9610ab['transaction_id'])); return true; } else { return false; } } } }