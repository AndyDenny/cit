<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
\CModule::IncludeModule('iblock');
//var_dump($_REQUEST);
$sAction = $_REQUEST["formname"];
require_once "./ext/".$sAction.".php";
 