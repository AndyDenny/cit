<?php
$name_item = htmlspecialchars($_REQUEST["name"]);
if (strlen($name_item)>0){
    $iblock_id_item = htmlspecialchars($_REQUEST["iblock_id"]);
    $bs = new CIBlockSection;
    $arFields = Array(
        "ACTIVE" => "Y",
        //"IBLOCK_SECTION_ID" => $IBLOCK_SECTION_ID,
        "IBLOCK_ID" => $iblock_id_item,
        "NAME" => $name_item,
        "SORT" => 500,
    );
    if($ID = $bs->Add($arFields)){
        $obCreateCode = new CIBlockSection();
        $sCode = $obCreateCode->createMnemonicCode([
            "NAME" => $name_item,
            "IBLOCK_ID" => $iblock_id_item,
            "ID" => $ID
        ]);
        $_UpdateSection = new CIBlockSection();
        $_UpdateSection->Update($ID,["CODE"=>$sCode]);
        echo "<div class='status-ok' data-id='".$ID."'>Успешно добавлено (".$sCode.")</div>";
    }else{
        echo "<div class='status-error'>Ошибка: '".$bs->LAST_ERROR."'</div>";
    }
}else{
    echo "Поле пустое";
}