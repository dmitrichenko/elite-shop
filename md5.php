<?php
$arr = array(
    'vKontakte',
    'Vkontakte URL: ',
);

foreach($arr as $item){
    echo 'md5('.$item.') = ' . md5($item).'<br/>';
}