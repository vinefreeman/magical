<?php
$fonts = file_get_contents('fonts.txt' , FILE_USE_INCLUDE_PATH);
$fonts = json_decode($fonts,true);

$items = $fonts['items'];
$i = 0;
$str = '';
foreach ($items as $item) {
    $i++;
    $str .= $item['family'];

    echo $str;
}



?>