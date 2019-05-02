<?php

class Request
{

    public $action;
    public $values;
    public $logger;
    public $result;

    public function __construct($action = null, $values = null)
    {

        if ($action == null) {
            $this->$action = "default";
        } else {
            $this->action = $action;
        }

        if (gettype($values) == "array" && count($values) > 0) {
            $this->values = array();
            $okTypes = array('boolean', 'integer', 'double', 'string');
            foreach ($values as $value) {
                if ($value === true) {
                    $this->values[] = "true";
                } else if ($value === false) {
                    $this->values[] = "false";
                } else if (gettype($value) == 'integer' || gettype($value) == 'double') {
                    $this->values[] = (string) $value;
                } else if (gettype($value) == 'string') {
                    $this->values[] = $value;
                } else {
                    $this->values[] = "UNSUPPORTED VARIABLE TYPE";
                }
            }
        } else {
            $this->values = array();
        }

        $this->logger = new Logger("Request");
        $this->logActionAndValues();

    }

    public function SetResult($result)
    {
        $this->result = (string) $result;
        $this->logger->Message("Result: " . $result);
    }

    public function logActionAndValues()
    {
        $this->logger->Section("Building Request");
        $this->logger->Message("action: '$this->action'");

        $valueCount = count($this->values);
        if ($valueCount == 0) {
            $this->logger->Message("values array is empty");
        } else if ($valueCount == 0) {
            $this->logger->Message("values array contains $valueCount item:");
        } else {
            $this->logger->Message("values array contains $valueCount items:");
        }

        for ($i = 0; $i < $valueCount; $i++) {
            $value = $this->values[$i];
            $this->logger->Message("\$values[$i] = $value");
        }
    }

}
