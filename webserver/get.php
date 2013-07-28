<?php
$cpu = $_GET['cpu'];
$room = $_GET['room'];

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
