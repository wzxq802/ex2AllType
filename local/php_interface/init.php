<?
use Bitrix\Main\Loader;

AddEventHandler("main", "OnProlog", function () {
    if (!Loader::includeModule("iblock")) {
        return;
    }

    global $APPLICATION;

    $currentPage = $APPLICATION->GetCurPage(false);
    $iblockId = 5; 

    $res = CIBlockElement::GetList(
        [],
        [
            "IBLOCK_ID" => $iblockId,
            "NAME" => $currentPage,
            "ACTIVE" => "Y"
        ],
        false,
        false,
        ["ID", "IBLOCK_ID", "NAME", "PROPERTY_title", "PROPERTY_description"]
    );

    if ($item = $res->GetNext()) {
        if (!empty($item["PROPERTY_title"]["VALUE"])) {
            $APPLICATION->SetTitle($item["PROPERTY_title"]["VALUE"]);
            $APPLICATION->SetPageProperty("title", $item["PROPERTY_title"]["VALUE"]);
        }
        if (!empty($item["PROPERTY_description"]["VALUE"])) {
            $APPLICATION->SetPageProperty("description", $item["PROPERTY_description"]["VALUE"]);
        }
    }
});

AddEventHandler("main", "OnBeforeEventSend", "CustomizeFeedbackAuthor");
function CustomizeFeedbackAuthor(&$arFields, &$arTemplate)
{
    if ($arTemplate["EVENT_NAME"] == "FEEDBACK_FORM") {
        global $USER;

        $formName = $arFields["AUTHOR"]; 

        if ($USER->IsAuthorized()) {
            $arFields["AUTHOR"] = "Пользователь авторизован: " .
                $USER->GetID() . " (" . $USER->GetLogin() . ") " . $USER->GetFullName() .
                ", данные из формы: " . $formName;
        } else {
            $arFields["AUTHOR"] = "Пользователь не авторизован, данные из формы: " . $formName;
        }
        CEventLog::Add(array(
            "SEVERITY" => "INFO",
            "AUDIT_TYPE_ID" => "Замена данных в отсылаемом письме – [AUTHOR].",
            "MODULE_ID" => "main",
            "ITEM_ID" => "",
            "DESCRIPTION" => "Замена данных в отсылаемом письме – " . $arFields["AUTHOR"]
        ));
    }
}

?>