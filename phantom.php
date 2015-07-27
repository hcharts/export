<?php

/**
* 基于 Phantomjs 实现的导出服务器
*/



$options = $_POST['options'];
$const = isset($_POST['const']) ? $_POST['const'] : "Chart";
$filename = (string) $_POST['filename'];

// prepare variables
if (!$filename or !preg_match('/^[A-Za-z0-9\-_ ]+$/', $filename)) {
  $filename = 'chart';
}


$tempName = md5(rand());
if(!file_put_contents("temp/$tempName.json", $options)) {
  echo "发生错误，无法写入临时文件，请讲 /tmp 文件设置为可写权限（777）";
}

$outfileName = md5(rand());
exec("phantomjs phantomjs/highcharts-convert.js -infile temp/$tempName.json -outfile temp/$outfileName.png -constr Chart") or die("erroe");

// if (!is_file('temp/$outfileName.png') || filesize('temp/$outfileName.png') < 10) {
//  echo "转换失败";
// } else {
//  header("Content-Disposition: attachment; filename=\"$filename.png\"");
//  header("Content-Type: $type");
//  header("Content-Length:".filesize('temp/$outfileName.png'));
//  echo file_get_contents('temp/$outfileName.png');
// }

// // delete it
// unlink("temp/$tempName.json");
// unlink('temp/$outfileName.png');


?>