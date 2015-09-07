<?php

/**
* 基于 Phantomjs 实现的导出服务器
*/

// Phantomjs 路径
define ('Phantom_HOME', '/usr/local/bin/');
ini_set('magic_quotes_gpc', 'off');

$type = $_POST['type'];
$svg = (string) $_POST['svg'];
$filename = (string) $_POST['filename'];

// prepare variables
if (!$filename or !preg_match('/^[A-Za-z0-9\-_ ]+$/', $filename)) {
  $filename = 'chart';
}
if (get_magic_quotes_gpc()) {
  $svg = stripslashes($svg);
}

// check for malicious attack in SVG
if(strpos($svg,"<!ENTITY") !== false || strpos($svg,"<!DOCTYPE") !== false){
  exit("Execution is topped, the posted SVG could contain code for a malicious attack");
}

$tempName = md5(rand());

// allow no other than predefined types
if ($type == 'image/png') {
  $typeString = '-m image/png';
  $ext = 'png';

} elseif ($type == 'image/jpeg') {
  $typeString = '-m image/jpeg';
  $ext = 'jpg';

} elseif ($type == 'application/pdf') {
  $typeString = '-m application/pdf';
  $ext = 'pdf';

} elseif ($type == 'image/svg+xml') {
  $ext = 'svg';

} else { // prevent fallthrough from global variables
  $ext = 'txt';
}

$outfile = "tmp/$tempName.$ext";

if (isset($typeString)) {

  // size
  $width = '';
  if ($_POST['width']) {
    $width = (int)$_POST['width'];
    if ($width) $width = "-w $width";
  }

  $height = '';

  if($_POST['height']) {
    $height = (int)$_POST['height'];
    if ($height) $height = "-h $height";
  }

  // generate the temporary file
  if (!file_put_contents("tmp/$tempName.svg", $svg)) {
    die("Couldn't create temporary file. Check that the directory permissions for
      the /temp directory are set to 777.");
  }

  exec(Phantom_HOME."phantomjs highcharts-convert.js -infile tmp/$tempName.svg -outfile $outfile -constr Chart") or die("error");

  if (!is_file($outfile) || filesize($outfile) < 10) {
   echo "转换失败";
  } else {
   header("Content-Disposition: attachment; filename=\"$filename.png\"");
   header("Content-Type: $type");
   header("Content-Length:".filesize($outfile));
   echo file_get_contents($outfile);
  }

  // delete it
  unlink("tmp/$tempName.svg");
  unlink($outfile);


} else {
  include "about.html";
}


/*
$options = $_POST['options'];
$const = isset($_POST['const']) ? $_POST['const'] : "Chart";
$filename = (string) $_POST['filename'];

// prepare variables
if (!$filename or !preg_match('/^[A-Za-z0-9\-_ ]+$/', $filename)) {
  $filename = 'chart';
}

//
$tempName = md5(rand());

// echo $tempName;

if(!file_put_contents("tmp/$tempName.json", $options)) {
  echo "发生错误，无法写入临时文件，请讲 /tmp 文件设置为可写权限（777）";
}

$outfileName = md5(rand());
exec(Phantom_HOME."phantomjs highcharts-convert.js -infile tmp/$tempName.json -outfile tmp/$outfileName.png -constr Chart") or die("erroe");

// echo $outfileName;

if (!is_file('tmp/'.$outfileName.'.png') || filesize('tmp/'.$outfileName.'.png') < 10) {
 echo "转换失败";
} else {
 header("Content-Disposition: attachment; filename=\"$filename.png\"");
 header("Content-Type: $type");
 header("Content-Length:".filesize('tmp/'.$outfileName.'.png'));
 echo file_get_contents('tmp/'.$outfileName.'.png');
}

// delete it
unlink("temp/".$tempName.".json");
unlink('temp/'.$outfileName.'.png');
*/

?>