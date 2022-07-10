<?php

namespace App\Helpers\Form;

use App\Core\Model;

class Form
{
    private Model $model;

    public function __construct(Model $model, string $method, string $action = '') {
        $this->model = $model;
        echo "<form method='$method' action='$action'>";
    }

    public function input(string $attribute, string $value = NULL) {
        return new Input($this->model, $attribute, $value);
    }

    public function select(string $attribute, array $options, array $inputValue = NULL) {
        return new Select($this->model, $attribute, $options, $inputValue);
    }

    public function switch(string $attribute) {
        return new Switchbox($this->model, $attribute);
    }

    public function button(string $text = 'button', string $type = 'submit') {
        $button = "";

        switch($type) {
            case 'submit':
                $button = "<button type='submit' class='btn btn-primary'>$text</button>";
                break;
            case 'reset':
                $button = "<button type='reset' class='btn btn-outline-danger'>Reset</button>";
                break;
        }

        return $button;
    }

    public function close() {
        echo "</form>";
    }
}