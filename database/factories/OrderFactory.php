<?php
use Faker\Generator as Faker; $sp7b3b42->define(App\Order::class, function (Faker $spc61945) { $sp64a7d9 = date('YmdHis') . mt_rand(10000, 99999); while (\App\Order::whereOrderNo($sp64a7d9)->exists()) { $sp64a7d9 = date('YmdHis') . mt_rand(10000, 99999); } $sp68ce3d = random_int(0, 1) ? $spc61945->email : 'user01@qq.com'; $spf4cec7 = 1000; $spa68933 = random_int(0, 1) * 100; $spe4f9f4 = $spf4cec7 - $spa68933; return array('user_id' => 2, 'order_no' => $sp64a7d9, 'product_id' => 1, 'count' => 1); });