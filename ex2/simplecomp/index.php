<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент");
?><?$APPLICATION->IncludeComponent(
	"ex2:simplecomp.exam_71",
	"",
	Array(
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CLASS" => "7",
		"PRODUCTS_IBLOCK_ID" => "2",
		"PROPERTY" => "FIRMA",
		"TEMPLATE" => ""
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>