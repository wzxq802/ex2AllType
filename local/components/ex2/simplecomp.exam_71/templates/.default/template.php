<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<?=GetMessage("SIMPLECOMP_EXAM2_TIME_71")?>: <?= time(); ?>
<?if(count($arResult["CLASS"]) > 0):?>
    <ul>
    <?foreach($arResult["CLASS"] as $arClass):?>
        <li>
            <b>
                <?= $arClass[0]["NAME"]?>
            </b>
            <?if(count($arResult["ELEMENTS"]) > 0):?>
            <ul>
                <?foreach($arResult["ELEMENTS"] as $arElement):?>
                <li>
                    <?= $arElement["NAME"]?> - 
                    <?= $arElement["PROPERTIES"]["PRICE"]["VALUE"]?> - 
                    <?= $arElement["PROPERTIES"]["MATERIAL"]["VALUE"]?> -
                    <?= $arElement["PROPERTIES"]["ARTNUMBER"]["VALUE"]?> 
                    <a href="<?= $arElement["DETAIL_PAGE_URL"]?>">Детальный просмотр</a>
                    
                </li>
                <?endforeach;?>
            </ul>
            <?endif;?>
        </li>
    <?endforeach;?>
    </ul>
<?endif;?>