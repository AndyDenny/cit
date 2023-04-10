<?php
$name_item = htmlspecialchars($_REQUEST["name"]);
if(strlen($name_item)>0){
    $iblock_id_item = htmlspecialchars($_REQUEST["iblock_id"]);
    $decription_item =  htmlspecialchars($_REQUEST["description"]);
    $arCatname_item = $_REQUEST["catname"];
    $date_item =  htmlspecialchars($_REQUEST["date"]);
//
    $date_item = htmlspecialchars($_REQUEST["date"]);
    $date_item = explode("-",$date_item);
    $date_item = implode(".",array_reverse($date_item));
//
    $user_id = $USER!=null ? $USER->GetID() : 1;  //завести ID для гостевого усера
    $arCatname_item = explode(',',$arCatname_item);
    $el = new CIBlockElement;
    $arFile = false;
    if ( isset ($_FILES['picture'])) {
        $arFile = CFile::SaveFile($_FILES['picture'],"/medialibrary");
        $arFile = CFile::MakeFileArray($arFile);
    }
    $arLoadProductArray = Array(
        "MODIFIED_BY"    => $user_id,      // элемент изменен текущим пользователем
        "IBLOCK_SECTION" => $arCatname_item,
        "IBLOCK_ID"      => $iblock_id_item,                // TODO - $arParams["IBLOCK_ID"]
        "NAME"           => $name_item,
        "ACTIVE"         => "Y",            // активен
        "ACTIVE_FROM"    => $date_item,
        "DETAIL_TEXT"    => $decription_item,
        "DETAIL_PICTURE" => $arFile
    );

    if($PRODUCT_ID = $el->Add($arLoadProductArray)) {
        echo "<div class='status-ok' data-id='" . $PRODUCT_ID . "'>Успешно добавлено</div>";
        $obCreateCode = new CIBlockElement();
        $sCode = $obCreateCode->createMnemonicCode([
            "NAME" => $name_item,
            "IBLOCK_ID" => $iblock_id_item,
        ]);
        $is_Update = $obCreateCode->Update($PRODUCT_ID, [
            "CODE" => $sCode
        ]);
    }else {
        echo "<div class='status-error'>Ошибка: '" . $el->LAST_ERROR . "'</div>";
    }

}else{
    echo "Не указано название";
}
