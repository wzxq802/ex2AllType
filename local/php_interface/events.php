<?php
use Bitrix\Main\EventManager;

EventManager::getInstance()->addEventHandler('main', 'OnBeforeProlog', ['Ex2', 'ex2_94']);

class Ex2 {
    public static function ex2_94() {
        global $APPLICATION;

        if (!\Bitrix\Main\Loader::includeModule('iblock')) {
            return;
        }

        $currentPageUrl = $APPLICATION->GetCurPage();
        $iblockCode = 'metategs';
        $iblockId = 0;

        $res = CIBlock::GetList([], ['CODE' => $iblockCode]);
        if ($arIblock = $res->Fetch()) {
            $iblockId = $arIblock['ID'];
        }

        if ($iblockId > 0) {
            $arFilter = [
                'IBLOCK_ID' => $iblockId,
                'NAME' => $currentPageUrl,
                'ACTIVE' => 'Y'
            ];

            $arSelect = ['ID', 'PROPERTY_TITLE', 'PROPERTY_DESCRIPTION'];
            $ob = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);

            if ($arResult = $ob->Fetch()) {
                if (!empty($arResult['PROPERTY_TITLE_VALUE'])) {
                    $APPLICATION->SetTitle($arResult['PROPERTY_TITLE_VALUE']);
                    $APPLICATION->SetPageProperty('title', $arResult['PROPERTY_TITLE_VALUE']);
                }

                if (!empty($arResult['PROPERTY_DESCRIPTION_VALUE'])) {
                    $APPLICATION->SetPageProperty('description', $arResult['PROPERTY_DESCRIPTION_VALUE']);
                }
            }
        }
    }
}
