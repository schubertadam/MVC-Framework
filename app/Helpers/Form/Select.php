<?php

namespace App\Helpers\Form;

use App\Core\Model;

class Select extends Field
{
    private array $options;
    private ?array $inputValue;

    public function __construct(Model $model, string $attribute, array $options, array $inputValue = NULL) {
        parent::__construct($model, $attribute);
        $this->options = $options;
        $this->inputValue = $inputValue;
    }

    private function createOptions(array $options): string {
        $data = "";

        if(is_multi_array($options)) {
            $options = to_select_field_array($options);
        }

        foreach($options as $key => $value) {
            $data .= "<option value='$key'>$value</option>";
        }

        return $data;
    }

    private function getDefault() {
        if(is_null($this->inputValue)) {
            return "";
        }

        $data = "";
        foreach($this->inputValue as $key => $value) {
            $data = "<option value='$key' selected>$value</option>";
        }

        return $data;
    }

    public function renderInput(): string {
        $default = $this->getDefault();
        $selectOptions = $this->createOptions($this->options);
        $errorClass = $this->model->hasError($this->attribute) ? 'is-invalid' : '';

        return "
            <select name='$this->attribute' class='form-select $errorClass'>
                $default
                $selectOptions
            </select>
        ";
    }
}