<?php
$name_item = htmlspecialchars($_REQUEST["name"]);
$id_category = intval(htmlspecialchars($_REQUEST["catname"]));
$iblock_id_item = htmlspecialchars($_REQUEST["iblock_id"]);
if (strlen($name_item)>0){
    // update category
    $obCreateCode = new CIBlockSection();
    $sCode = $obCreateCode->createMnemonicCode([
        "NAME" => $name_item,
        "IBLOCK_ID" => $iblock_id_item,
        "ID" => $id_category
    ]);
    $is_Update = $obCreateCode->Update($id_category,[
        "NAME" => $name_item,
        "CODE" => $sCode
    ]);
    echo $is_Update ? "Категория обновлена" : "Не получилось обновить" ;
}else{
    $is_Delete = CIBlockSection::Delete($id_category);
    echo $is_Delete ? "Категория удалена" : "Не получилось удалить" ;
}