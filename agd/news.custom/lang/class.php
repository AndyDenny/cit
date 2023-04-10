<?
namespace myNamespace;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main;

class ManipulationWrapper extends CBitrixComponent{

    public function __construct()
    {
        return "create";
    }

    public function test(string $datep="m.d.y"){
        $arResult['DATE'] = date($datep);
    }

    public function executeComponent()
    {
          $this->includeComponentTemplate();
    }
}