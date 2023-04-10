<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
\Bitrix\Main\Loader::includeModule('iblock');

$obIblockTypes = \Bitrix\Iblock\TypeTable::getList([
    'select' => ['*','NAME' => 'LANG_MESSAGE.NAME'],
    'order' => ['ID' => 'ASC'],
]);
while ($arItem = $obIblockTypes->fetch()){
    $arIblockTypesList[] = "[".$arItem["ID"]."] ".$arItem["NAME"];
}
$obIblocks = \Bitrix\Iblock\IblockTable::getList([
    'select' => ['ID','NAME']
]);
while ($arItem = $obIblocks->fetchObject()){
//    'IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'])
    $arIblocksList[] = "[".$arItem->getId()."] ".$arItem->getName();
}

$arSortOrder = [
    "ASC"=>"По возрастанию",
    "DESC" => "По убыванию"
];
$arSortParams = [
    "ID" => "По номеру записи",
    "NAME" => "По имени",
    "ACTIVE_FROM" => "По дате создания",
    "IBLOCK_SECTION_ID" => "По категории"
];

$arComponentParameters = array(
    "GROUPS" => array(),
    "PARAMETERS" => array(
        "IBLOCK_TYPE" => array(
            "PARENT" => "BASE",
            "NAME" => "Тип инфоблока",
            "TYPE" => "LIST",
            "VALUES" => $arIblockTypesList,
            "DEFAULT" => "",
            "REFRESH" => "Y",
        ),
        "IBLOCK" => array(
            "PARENT" => "BASE",
            "NAME" => "Инфоблок",
            "TYPE" => "LIST",
            "VALUES" => $arIblocksList,
            "DEFAULT" => '',
            "REFRESH" => "Y",
        ),
        "SORTING_ORDER"  =>  Array(
            "PARENT" => "BASE",
            "NAME" => "Сортировка",
            "TYPE" => "LIST",
            "DEFAULT" => "DESC",
            "VALUES" => $arSortParams,
        ),
        "SORTING_BY"  =>  Array(
            "PARENT" => "BASE",
            "NAME" => "Порядок сотрировки",
            "TYPE" => "LIST",
            "DEFAULT" => "ACTIVE_FROM",
            "VALUES" => $arSortOrder,
        ),
    ),
);