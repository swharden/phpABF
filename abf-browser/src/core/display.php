<?php

class Display
{
    // Provide methods to generate and display HTML given a Request

    public $request;

    public function __construct($request)
    {
        $this->request = $request;
        //TODO: verify this is a request object
        $this->request->logger->Section("The displayer is now managing this request");
    }

    public function GetMessagesAsText()
    {
        $loggerName = $this->request->logger->GetName();
        $txt = "##### Logger: $loggerName #####\n";
        foreach ($this->request->logger->GetMessages() as $message) {
            $messageParts = explode(" | ", $message, 4);
            if (count($messageParts) != 4) {
                continue;
            }
            $messageTime = trim($messageParts[0]);
            $messageSource = trim($messageParts[1]);
            $messageType = trim($messageParts[2]);
            $message = trim($messageParts[3]);
            if (strlen($message) == 0) {
                continue;
            }
            if (strstr($messageType, "SECTION")) {
                $txt .= "\n[$messageTime] $message\n";
            } else if (strstr($messageType, "ERROR")) {
                $txt .= "\n!!!!! [$messageTime] $message !!!!!\n";
            } else {
                $txt .= "[$messageTime] $message\n";
            }
        }
        return trim($txt);
    }

    public function GetMessagesAsHtml()
    {
        $html = "<div class='logMessageFrame'>";
        $loggerName = $this->request->logger->GetName();
        $html .= "<div class='logTitle'>Logger: $loggerName</div>";
        foreach ($this->request->logger->GetMessages() as $message) {
            $messageParts = explode(" | ", $message, 4);
            if (count($messageParts) != 4) {
                continue;
            }
            $messageTime = trim($messageParts[0]);
            $messageSource = trim($messageParts[1]);
            $messageType = trim($messageParts[2]);
            $message = trim($messageParts[3]);
            if (strlen($message) == 0) {
                continue;
            }
            if (strstr($messageType, "SECTION")) {
                $divClass = "logSection";
            } else if (strstr($messageType, "ERROR")) {
                $divClass = "logError";
            } else {
                $divClass = "logMessage";
            }
            $html .= "<div class='$divClass'>[$messageTime] $message</div>";

        }
        $html .= "</div>";
        return trim($html);
    }

    public function GetMessagesAsHtmlMinimal()
    {
        $html = '';
        foreach ($this->request->logger->GetMessages() as $message) {
            $messageParts = explode(" | ", $message, 4);
            if (count($messageParts) != 4) {
                continue;
            }
            $messageTime = trim($messageParts[0]);
            $messageSource = trim($messageParts[1]);
            $messageType = trim($messageParts[2]);
            $message = trim($messageParts[3]);
            if (strlen($message) == 0) {
                continue;
            }
            if (strstr($messageType, "SECTION")) {
                $divClass = "logSection";
            } else if (strstr($messageType, "ERROR")) {
                $divClass = "logError";
            } else {
                $divClass = "logMessage";
            }
            $html .= "<div class='$divClass'>[$messageTime] $message</div>";

        }
        return trim($html);
    }

    public function EchoLog($html = true, $includeTopAndBot = false)
    {
        if ($includeTopAndBot) {
            include "../templates/top.php";
        }

        if ($html) {
            echo $this->GetMessagesAsHtml();
        } else {
            echo $this->GetMessagesAsText();
        }

        if ($includeTopAndBot) {
            include "../templates/bot.php";
        }
    }
}
