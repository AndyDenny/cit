<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

\Bitrix\Main\Loader::includeModule('iblock');
use \Bitrix\Iblock\Elements\ElementShopnewsTable;
use \Bitrix\Iblock\ElementTable;

class AgdNewsWrapper extends CBitrixComponent
{

    public function getAllNewsItems(){
        $elements = ElementTable::getList([
            'select' => ['ID','NAME','CODE','DATE_CREATE','IBLOCK_SECTION_ID'],
            'filter' => ['ACTIVE' => 'Y',"IBLOCK_ID"=>intval($this->arParams['IBLOCK'])+1],
            'order' => [$this->arParams["SORTING_ORDER"] => $this->arParams["SORTING_BY"]]
        ])->fetchAll();

        return $elements;
    }
    public function getNewsItem(string $url=""){
        $element = ElementTable::getList([
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
        $arSections = \Bitrix\Iblock\SectionTable::getList([
            'select' => ["NAME","CODE","ID"],
            'filter' => [
                "IBLOCK_ID"=>intval($this->arParams['IBLOCK'])+1,
                "GLOBAL_ACTIVE"=>"Y"
            ],
        ])->fetchAll();
        return $arSections;
    }

    public function executeComponent()
    {

        $this->arResult['TEST'] = $this->getNewsItem();
        $this->arResult['CATEGORIES'] = $this->getNewsCategoriesList();
        $this->arResult["ALLITEMS"] = $this->getAllNewsItems();
        $this->includeComponentTemplate();
    }

}?>