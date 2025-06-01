<?
global $CACHE_MANAGER;
if($this->startResultCache(false, array($USER->GetGroups(), "/servicesIblock"))) {
	if (\Bitrix\Main\Loader::includeModule("iblock")) {
        $CACHE_MANAGER->StartTagCache($this->GetCachePath());
        $CACHE_MANAGER->RegisterTag("iblock_id_" . intval($arParams["CLASS"]));
    }
    $arClassIf = array();
    $arClassIfId = array();
	$arResult["COUNT"] = 0;
    $arSelectElements = array (
        "ID",
        "IBLOCK_ID",
        "NAME",
    );
    $arFilterElements = array (
        "IBLOCK_ID" => $arParams["CLASS"],
        "CHECK_PERMISSIONS" =>$arParams["CACHE_GROUPS"],
        "ACTIVE" => "Y"
    );
    $arSortElements = array ("NAME" => "ASC");
    $rsElements = CIBlockElement::GetList(array(), $arFilterElements, false, false, $arSelectElements);
    while($arElement = $rsElements->GetNext())
    {
        $arClassIf[$arElement["ID"]][] = $arElement;
        $arClassIfId[] = $arElement["ID"];
    }
	$arResult["COUNT"] = count( $arClassIfId);
    $arSelectElementsCatalog = array (
        "ID",
        "IBLOCK_ID",
        "IBLOCK_SECTION_ID",
        "NAME",
    );
    $arFilterElementsCatalog = array (
        "IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
        "CHECK_PERMISSIONS" =>$arParams["CACHE_GROUPS"],
        "PROPERTY_".$arParams["PROPERTY"] => $arClassIfId,
        "ACTIVE" => "Y"
    );
    $arSortElementsCatalog = array ("NAME" => "ASC");

    $arResult["ELEMENTS"] = array();
    $rsElements = CIBlockElement::GetList(array(), $arFilterElementsCatalog, false, false, $arSelectElementsCatalog);
    while($rsEl = $rsElements->GetNextElement())
    {
        $arField = $rsEl->GetFields();
        $arField["PROPERTY"] = $rsEl->GetProperties();
        
        foreach($arField["PROPERTY"]["FIRMA"]["VALUE"] as $value) {
            $arClassIf["CLASS"][$value]["ELEMENTS_ID"][] = $arField["ID"];
        }
    }
    $arResult["CLASS"] = $arClassIf;
	$this->SetResultCacheKeys(array("COUNT"));

	$CACHE_MANAGER->EndTagCache();
    $this->SetResultCacheKeys(["COUNT"]);
} else {
    $this->abortResultCache();
}
if(intval($arParams["PRODUCTS_IBLOCK_ID"]) > 0)
{
	
	//iblock elements
	$arSelectElems = array (
		"ID",
		"IBLOCK_ID",
		"NAME",
		"DETAIL_PAGE_URL"
	);
	$arFilterElems = array (
		"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
		"ACTIVE" => "Y"
	);
	$arSortElems = array (
			"NAME" => "ASC"
	);
	
	$arResult["ELEMENTS"] = array();
	$rsElements = CIBlockElement::GetList($arSortElems, $arFilterElems, false, false, $arSelectElems);
	while ($obElement = $rsElements->GetNextElement()) {
    	$arFields = $obElement->GetFields();
    	$arProps = $obElement->GetProperties();

   	 	$arFields['PROPERTIES'] = $arProps;
    	$arResult["ELEMENTS"][] = $arFields;
	}
	//iblock sections
	$arSelectSect = array (
			"ID",
			"IBLOCK_ID",
			"NAME",
	);
	$arFilterSect = array (
			"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
			"ACTIVE" => "Y"
	);
	$arSortSect = array (
			"NAME" => "ASC"
	);
	
	$arResult["SECTIONS"] = array();
	$rsSections = CIBlockSection::GetList($arSortSect, $arFilterSect, false, $arSelectSect, false);
	while($arSection = $rsSections->GetNext())
	{
		$arResult["SECTIONS"][] = $arSection;
	}
		
	// user
	$arOrderUser = array("id");
	$sortOrder = "asc";
	$arFilterUser = array(
		"ACTIVE" => "Y"
	);
	
	$arResult["USERS"] = array();
	$rsUsers = CUser::GetList($arOrderUser, $sortOrder, $arFilterUser); // выбираем пользователей
	while($arUser = $rsUsers->GetNext())
	{
		$arResult["USERS"][] = $arUser;
	}	
	
	
}
global $APPLICATION;
$APPLICATION->SetTitle(GetMessage("SIMPLECOMP_EXAM2_COUNT_71") . $arResult["COUNT"]);
$this->includeComponentTemplate();	
?>