<?php
class WxPayNotify extends WxPayNotifyReply { public final function Handle($sp65077c = true) { $sp9610ab = WxpayApi::notify(array($this, 'NotifyCallBack'), $spdfd2b6); if ($sp9610ab == false) { $this->SetReturn_code('FAIL'); $this->SetReturn_msg($spdfd2b6); $this->ReplyNotify(false); return; } else { $this->SetReturn_code('SUCCESS'); $this->SetReturn_msg('OK'); } $this->ReplyNotify($sp65077c); } public function NotifyProcess($sp29e0c7, &$spdfd2b6) { return true; } public final function NotifyCallBack($sp29e0c7) { $spdfd2b6 = 'OK'; $sp9610ab = $this->NotifyProcess($sp29e0c7, $spdfd2b6); if ($sp9610ab == true) { $this->SetReturn_code('SUCCESS'); $this->SetReturn_msg('OK'); } else { $this->SetReturn_code('FAIL'); $this->SetReturn_msg($spdfd2b6); } return $sp9610ab; } private final function ReplyNotify($sp65077c = true) { if ($sp65077c == true && $this->GetReturn_code() == 'SUCCESS') { $this->SetSign(); } WxpayApi::replyNotify($this->ToXml()); } }