<?php

$since = $_GET['s']/1000;

$data = file('data_cpu.csv');
foreach($data as $line)
{
	$arr = explode(';',$line);
	$arr[1] = trim($arr[1]);
	if($arr[1]>$since) $cpu[] = array('data'=>$arr[0], 'time'=>($arr[1]*1000));
}

$data = file('data_room.csv');
foreach($data as $line)
{
	$arr = explode(';',$line);
	$arr[1] = trim($arr[1]);
	if($arr[1]>$since) $room[] = array('data'=>$arr[0], 'time'=>($arr[1]*1000));
}

echo json_encode(array('carr'=>$cpu,'rarr'=>$room));