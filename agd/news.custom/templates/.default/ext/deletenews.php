<?php
$id_item = intval(htmlspecialchars($_REQUEST["item_news_id"]));
$is_Delete = CIBlockElement::Delete($id_item);
echo $is_Delete ? "Новость удалена" : "Не получилось удалить" ;
//var_dump($_REQUEST);