<?php

/**
 * DISCLAIMER: Don't use www.highcharts.com/studies/csv-export/csv.php in 
 * production! This file may be removed at any time.
 * 由Highcharts中文修改提供中文乱码解决办法
 */
$csv = $_POST['csv'];
$csv = iconv("utf-8","gbk",$csv);//转换成GBK编码

if ($csv) {
	header('Content-type: text/csv;charset=gbk');
	header('Content-disposition: attachment;filename=chart.csv');
	echo $csv;
}
?>