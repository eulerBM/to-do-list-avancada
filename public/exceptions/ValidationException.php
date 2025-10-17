<?php

class ValidationException extends Exception {

    private $status;

    public function __construct($message, $status = 400) {

        parent::__construct($message);
        $this->status = $status;

    }

    public function getStatus() {
        return $this->status;
    }
}
