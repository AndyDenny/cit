<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

\Bitrix\Main\Loader::includeModule('iblock');
use \Bitrix\Iblock\Elements\ElementShopnewsTable;

class AgdNewsWrapper extends CBitrixComponent
{

    public function getAllNewsItems(){
        $elements = ElementShopnewsTable::getList([
//            'select' => ['*'],
            'select' => ['ID','NAME','CODE','DATE_CREATE','IBLOCK_SECTION_ID'],
            'filter' => ['ACTIVE' => 'Y'],
            'order' => [$this->arParams["SORTING_ORDER"] => $this->arParams["SORTING_BY"]]
        ])->fetchAll();

        return $elements;
    }
    public static function getNewsItem(string $url=""){
        $element = ElementShopnewsTable::getList([
            'select' => ['*'],
            'filter' => ['CODE' => $url],
        ])->fetchObject();
        return $element;
    }

    public static function getItemCategoryName(int $elementId=0){
        $elementId = intval($elementId);
        $element = ElementShopnewsTable::getList([
            'select' => ['ID', 'SECTIONS'],
            'filter' => [
                'ID' => $elementId,
            ],
        ])->fetchObject();
        return $element;
    }

    public function getNewsCategoriesList(){
        /**
         * TODO
         *
         *  IBLOCK_ID - $arParams['IBLOCK_ID']!!
         *
         */

        $rsSections = \CIBlockSection::GetList(
            array(),
            array("IBLOCK_ID"=>$this->arParams['IBLOCK'],"GLOBAL_ACTIVE"=>"Y"),
            false,
            array("NAME","CODE","ID")
        )

        while ($arSection = $rsSections->getNext())
        {
           $arSections[] = $arSection->GetFields();
        }
        return $arSections;
    }

    public function executeComponent()
    {
        $this->arResult['CATEGORIES'] = $this->getNewsCategoriesList();
        $this->arResult["ALLITEMS"] = $this->getAllNewsItems();
        $this->includeComponentTemplate();
    }

}?>