<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;
$this_folder = $component->__template->__folder;
CJSCore::Init(array("jquery"));
//$this->addExternalJS($component->__template->__folder."/myscr.js");

//
echo "<pre>";
//var_dump($arResult);
echo "</pre>";


?>
<div class="my-action-menu">
    <div class="menu-item"><a href="?addnew=">Добавить новость</a></div>
    <div class="menu-item"><a href="?addcat=">Добавить категорию</a></div>
    <div class="menu-item"><a href="?updatecat=">Обновить категорию</a></div>
    <div class="menu-item"><a href="?categ=">Список категорий</a></div>
    <div class="menu-item news-list"><a href="#">Список новостей</a></div>
</div>

<?
if(array_key_exists("addcat" , $_REQUEST)):?>
    <h4>Создать категорию</h4>
    <form action="" enctype="multipart/form-data" method="post" name="addcategory" id="form-category_news-add">
        <div class="add-category_news-wrapper">
            <input type="text" class="item cat-iblockid" hidden name="iblock_id" value="3<?//=$arParams["IBLOCK_ID"]?>">
            <input type="text" class="item cat-name" name="name" placeholder="Название категории">
            <input type="submit"  value="<?=Loc::getMessage("ADD_CATEGORY_NAME")?>" class="add-category btn-submit">
        </div>
    </form>
    <hr>
    <div class="result"></div>
<? endif;?>

<?
if(array_key_exists("updatecat" , $_REQUEST)):?>
    <h4>Переименовать\удалить выбранную категорию</h4>
    <form action="" enctype="multipart/form-data" method="post" name="updatecategory" id="form-category_news-update">
        <div class="update-category_news-wrapper">
            <input type="text" class="item cat-iblockid" hidden name="iblock_id" value="<?=$arParams["IBLOCK"]?>">
            <input type="text" class="item cat-name" name="name" placeholder="Название категории">
            <select  class="item item-category" name="catname">
                <option disabled value="choose" selected>Выбрать категорию</option>
                <?foreach ($arResult["CATEGORIES"] as $category):?>
                    <option value="<?=$category["ID"]?>"><?=$category["NAME"]?></option>
                <?endforeach;?>
            </select>
            <input type="submit" disabled value="<?=Loc::getMessage("UPDATE_CATEGORY")?>" class="update-category btn-submit item">
            <div class="item delete-wrapper">
                <input type="button" data-name="<?=Loc::getMessage("DELETE_CATEGORY")?>" value="<?=Loc::getMessage("DELETE_CATEGORY")?>" class="btn-hider">
                <div class="item hider-wrapper">
                    <input type="submit" value="<?=Loc::getMessage("AGREE")?>" class="delete-category agree btn-submit">
                    <input type="button" value="<?=Loc::getMessage("REFUSE")?>" class="refuse">
                </div>
            </div>
        </div>
    </form>
    <hr>
    <div class="result"></div>
<?endif;?>
<?
if(array_key_exists("addnew" , $_REQUEST)):
?>
    <h4>Создать новость</h4>
    <form action="" enctype="multipart/form-data" name="addnews" method="post" id="form-item_news-add">
        <div class="add-item_news-wrapper">
            <input type="text" class="item item-iblockid" hidden name="iblock_id" value="<?=$arParams["IBLOCK"]?>">
            <input type="text" class="item item-name" name="name" placeholder="Название новости">
            <textarea class="item item-description" name="description" placeholder="Описание новости"></textarea>
            <input type="file" class="item item-image" name="picture">
            <input type="date" class="item item-date" name="date" value="<?=date("Y-m-d")?>">
            <select size="4" class="item item-category" multiple name="catname">
                <option selected>Выбрать категорию(или несколько)</option>
                <? // TODO - сделать выпадашку со списком $arSection["ID"]\["NAME"] выборкой из $arParams["IBLOCK"]?>
                <?foreach ($arResult["CATEGORIES"] as $category):?>
                    <option value="<?=$category["ID"]?>"><?=$category["NAME"]?></option>
                <?endforeach;?>
            </select>
            <input type="submit" disabled value="<?=Loc::getMessage("ADD_NEWS")?>" class="add-news-item btn-submit">
        </div>
    </form>
    <hr>
    <div class="result"></div>

<?endif;?>
<?
if(count($_REQUEST)<1 || (count($_REQUEST)==1 && array_key_exists("clear_cache" , $_REQUEST)) ):                                                               // "main page" - all news
    if (count($arResult["ALLITEMS"])>0):?>
        <div class="news-wrapper">
            <?foreach ($arResult["ALLITEMS"] as $item):?>
            <div class="news-item">
                <div class="item-category-name">
                    <i><?
                        $obCategorySections = AgdNewsWrapper::getItemCategoryName($item["ID"])->getSections()->getAll();
                        if(count($obCategorySections)>1){
                            foreach ($obCategorySections as $section) {
                                echo $section->getName()." | ";
                            }
                        }else{
                            echo $obCategorySections[0]->getName();
                        }
                        ?></i>
                </div>
                <div class="item-name">
                    <a href="?item=<?=$item["CODE"]?>" class="item-href"><?=$item["NAME"]?></a>
                </div>
                <div class="item-date"><?=explode(" ",$item["DATE_CREATE"])[0]?></div>
            </div>
            <?endforeach;?>
        </div>
    <?endif;
endif;?>

<?
if(array_key_exists("item" , $_REQUEST)):                                     // "detail page" - one news
    $arNewsItem = new AgdNewsWrapper();
    $arNewsItem = $arNewsItem->getNewsItem($_REQUEST["item"]);
    if ($arNewsItem):?>
        <div class="news-item-detail">
        <?/* <div class="item-id"><i><?=$arNewsItem->getId();?></i></div> */?>
        <div class="item-name"><?=$arNewsItem->getName();?></div>
        <div class="item-picture"><?$rsFile = CFile::GetFileArray($arNewsItem->getDetailPicture()); ?>
            <img src="<?=$rsFile['SRC']?>">
        </div>
        <div class="item-text"><?=$arNewsItem->getDetailText();?></div>
        <hr>
        <div class="footer-item">
            <div class="info">
                <div class="item-category">
                    <b><?
                        $arSection = Bitrix\Iblock\SectionTable::getByPrimary($arNewsItem->getIblockSectionId(),[
                            'select'=>['NAME'],
                        ])->fetchRaw();
                        echo $arSection["NAME"];
                        ?>
                    </b>
                </div>
                <div class="item-date"><?=explode(" ",$arNewsItem->getDateCreate())[0]?></div>
            </div>
            <div class="remove">
                <form action="" enctype="multipart/form-data" method="post" name="deletenews" id="form-news-delete">
                    <div class="item delete-wrapper">
                        <input hidden name="item_news_id" value="<?=$arNewsItem->getId();?>">
                        <input type="button" data-name="<?=Loc::getMessage("DELETE_ITEM")?>" value="<?=Loc::getMessage("DELETE_ITEM")?>" class="btn-hider">
                        <div class="item hider-wrapper">
                            <input type="submit" value="<?=Loc::getMessage("AGREE")?>" class="delete-category agree btn-submit">
                            <input type="button" value="<?=Loc::getMessage("REFUSE")?>" class="refuse">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
        <div class="result"></div>
    <?else:?>
        <div class="not-exist">
            <h3><i><?=Loc::getMessage("NOT_EXIST_ITEM")?></i></h3>
        </div>
    <?endif;?>
<?endif;?>

<?
if(array_key_exists("categ" , $_REQUEST)):
?>
    <div class="categories-wrapper">
        <?foreach ($arResult["CATEGORIES"] as $section):?>
            <div class="category-item">
                <div class="item-href">
                    <a href="?categ=<?=$section["CODE"]?>"><b><?=$section["NAME"]?></b></a>
                </div>
            </div>
        <?endforeach;?>
    </div>
<?
endif;
?>
<script>
    $(document).ready(function () {
        $(".btn-submit").on("click",function (e) {
            e.preventDefault();
            let sThisForm = $(this).parents("form");
            if (sThisForm.attr("name") == "addnews" ){
                let formData = new FormData();
                formData.append("picture",$('input.item-image')[0].files[0]);
                formData.append('formname',sThisForm.attr("name"));
                sThisForm.find('input[type="text"],input[type="date"]').each(function() {
                    let _field = $(this);
                    formData.append( _field.attr("name"),_field.val() );
                });
                sThisForm.find('textarea').each(function() {
                    let _field = $(this);
                    formData.append( _field.attr("name"),_field.val() );
                });
                sThisForm.find('select').each(function() {
                    let _field = $(this);
                    formData.append( _field.attr("name"),_field.val() );
                });
                console.log(formData)
                $.ajax({
                    url: '<?=$this_folder?>/ajax.php',
                    dataType: 'text',
                    cache: false,
                    contentType: false,
                    context: document.body,
                    processData: false,
                    data: formData,
                    type: 'post',
                })
                    .done(function(data) {
                        $( ".result" ).html( data );
                        $(sThisForm).trigger('reset');
                    })
                    .fail(function(data) {
                        $( ".result" ).html( data );
                        console.log(data)
                    })
            }else{
                let Data = 'formname='+sThisForm.attr("name") + '&' + sThisForm.serialize();
                $.post( "<?=$this_folder?>/ajax.php", Data )
                        .done(function(data) {
                        $( ".result" ).html( data );
                        $(sThisForm).trigger('reset');
                    })
                    .fail(function(data) {
                        $( ".result" ).html( data );
                        console.log(data)
                    })
            }



        });
    });
</script>
