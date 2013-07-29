<?php
$webserver_ip_and_port = 'http://192.168.1.115/temperatur/';
$device_id = '10-00080224e359';
$cputemp = "/sys/class/thermal/thermal_zone0/temp";
$wiretemp = "/sys/bus/w1/devices/'.$device_id.'/w1_slave";

$lct = 0;
$lwt = 0;

$data = array();

while(1)
{
  $data = file($wiretemp);
  $data = explode('t=',$data[1]);
  $wtemp = $data[1]/1000;
  $ctemp = implode(file($cputemp))/1000;

  $tdata = array('CPU'=>$ctemp,'room'=>$wtemp);

  echo "CPU: $ctemp\nRoommtemp: $wtemp\n";
  //var_dump($tdata);

  $null = file($webserver_ip_and_port."get.php?data=".rawurlencode(json_encode($tdata)));

  $lct = $ctemp;
  $lwt = $wtemp;
  sleep(60);
}