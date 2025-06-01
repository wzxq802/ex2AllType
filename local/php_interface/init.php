<?
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
require_once __DIR__ . '/events.php';
?>