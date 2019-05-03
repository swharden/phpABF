<?php

class Logger
{
    // stores and recalls log messages

    private $messages;
    private $name;
    private $timestampDate = false;
    private $timestampSeconds = true;

    private $timeStarted;

    public function __construct($name)
    {
        $this->name = (string) $name;
        $this->timeStarted = microtime(true);
        $this->Message("started logger");
    }

    private function GetTimeStarted()
    {
        $secondsElapsed = microtime(true) - $this->timeStarted;
        return $secondsElapsed;
    }

    public function Section($message)
    {
        $this->Message($message, null, "SECTION");
    }

    public function Message($message, $source = null, $messageType = "MESSAGE")
    {
        if ($source == null) {
            $source = $this->name;
        }

        if ($this->timestampDate) {
            $timestamp = GetDatetimeString();
        } else if ($this->timestampSeconds) {
            $timestamp = number_format($this->GetTimeStarted() * 1000, 3);
        } else {
            $timestamp = "";
        }

        $message = "$timestamp ms | $source | $messageType | $message";
        $this->messages[] = $message;
    }

    public function GetMessages()
    {
        return $this->messages;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function Clear(){
        $this->messages = array();
        $this->Message("restarted logger");
    }

}
