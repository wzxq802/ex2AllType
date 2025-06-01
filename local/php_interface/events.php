<?php
use Bitrix\Main\EventManager;

EventManager::getInstance()->addEventHandler('main', 'OnBeforeProlog', 'Ex2::ex2_94');

class Ex2 {
    public static function ex2_94() {
        global $APPLICATION;

        $currentPageUrl = $APPLICATION->GetCurPage(true);

        if (\Bitrix\Main\Loader::includeModule('iblock')) {
            $arFilter = [
                '=IBLOCK_CODE' => 'metategs',
                '=NAME' => $currentPageUrl,
            ];

            $arSelect = ['ID', 'PROPERTY_TITLE', 'PROPERTY_DESCRIPTION'];

            $ob = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);

            if ($arResult = $ob->Fetch()) {
                $APPLICATION->SetTitle($arResult['PROPERTY_TITLE_VALUE']);
                $APPLICATION->SetPageProperty('title', $arResult['PROPERTY_TITLE_VALUE']);
                $APPLICATION->SetPageProperty('description', $arResult['PROPERTY_DESCRIPTION_VALUE']);
            }
        }
    }
}