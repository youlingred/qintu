<?php
function convertCurrency($from, $to, $amount){
  $data = file_get_contents("http://www.baidu.com/s?wd={$from}%20{$to}&rsv_spt={$amount}");
  preg_match("/<div>1\D*=(\d*\.\d*)\D*<\/div>/",$data, $converted);
  $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
  return number_format(round($converted, 3), 1);
}
  $get_cur = convertCurrency("CNY","JPY","1");
  echo $get_cur;
 ?>