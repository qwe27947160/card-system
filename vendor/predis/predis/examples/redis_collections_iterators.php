<?php
 require __DIR__.'/shared.php'; use Predis\Collection\Iterator; $client = new Predis\Client($single_server, array('profile' => '2.8')); $client->del('predis:set', 'predis:zset', 'predis:hash'); for ($i = 0; $i < 5; ++$i) { $client->sadd('predis:set', "member:$i"); $client->zadd('predis:zset', -$i, "member:$i"); $client->hset('predis:hash', "field:$i", "value:$i"); } echo 'Scan the keyspace matching only our prefixed keys:', PHP_EOL; foreach (new Iterator\Keyspace($client, 'predis:*') as $key) { echo " - $key", PHP_EOL; } echo 'Scan members of `predis:set`:', PHP_EOL; foreach (new Iterator\SetKey($client, 'predis:set') as $member) { echo " - $member", PHP_EOL; } echo 'Scan members and ranks of `predis:zset`:', PHP_EOL; foreach (new Iterator\SortedSetKey($client, 'predis:zset') as $member => $rank) { echo " - $member [rank: $rank]", PHP_EOL; } echo 'Scan fields and values of `predis:hash`:', PHP_EOL; foreach (new Iterator\HashKey($client, 'predis:hash') as $field => $value) { echo " - $field => $value", PHP_EOL; } 