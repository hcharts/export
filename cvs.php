<?php

/**
 * DISCLAIMER: Don't use www.highcharts.com/studies/csv-export/csv.php in 
 * production! This file may be removed at any time.
 * ��Highcharts�����޸��ṩ�����������취
 */
$csv = $_POST['csv'];
$csv = iconv("utf-8","gbk",$csv);//ת����GBK����

if ($csv) {
	header('Content-type: text/csv;charset=gbk');
	header('Content-disposition: attachment;filename=chart.csv');
	echo $csv;
}
?>