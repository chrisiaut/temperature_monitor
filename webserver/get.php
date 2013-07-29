<?php
$data = rawurldecode($_GET['data']);
$json = json_decode($data,true);
$cpu = $json['CPU'];
$room = $json['room'];

if($cpu && $cpu!=85)
{
  $fh = fopen('data_cpu.csv', 'a');
  if(!$fh) die('file writing error. permissions?');
  fwrite($fh, "$cpu;".time()."\n");
  fclose($fh);
}

if($room)
{
  $fh = fopen('data_room.csv', 'a');
  if(!$fh) die('file writing error. permissions?');
  fwrite($fh, "$room;".time()."\n");
  fclose($fh);
}
