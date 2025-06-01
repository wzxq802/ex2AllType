<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID_71"),
			"PARENT" => "BASE",
			"TYPE" => "STRING",
		),
		"CLASS" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CLASS_IBLOCK_ID_71"),
			"PARENT" => "BASE",
			"TYPE" => "STRING",
		),
		"TEMPLATE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_TEMPLATE_71"),
			"TYPE" => "STRING",
		),
		"PROPERTY" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_PROPERTY_71"),
			"PARENT" => "BASE",
			"TYPE" => "STRING",
		),
		"CACHE_TIME" => array("DEFAULT" => 36000000),
		"CACHE_GROUPS" => Array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("IBLOCK_CACHE_GROUPS_71"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		),
);