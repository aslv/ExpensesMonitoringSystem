<?php
//$groups = array(1=>'Приятели', 2=>'Бивши', 3=>'Бъдещи', 4=>'Колеги', 5=>'Семейство');
$groups = array();
if(file_exists('includes/categories'))
{
    $categories = file('includes/categories');
    foreach($categories as $category)
    {
        $groups[] = $category;
    }
}

$heading = 'Система за следене на разходите';
$delim = '!';
$author = "&#169; Всички права запазени &#9786;";
$formatDate = 'Y-m-d';
?>
