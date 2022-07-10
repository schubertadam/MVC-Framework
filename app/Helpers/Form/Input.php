<?php

namespace App\Helpers\Form;

use App\Core\Model;

class Input extends Field
{
    public const TYPE_TEXT = 'text';
    public const TYPE_EMAIL = 'email';
    public const TYPE_NUMBER = 'number';
    public const TYPE_PASSWORD = 'password';

    private string $fieldType;
    // can be null if there was no post
    private ?string $inputValue;

    public function __construct(Model $model, string $attribute, string $inputValue = NULL) {
        parent::__construct($model, $attribute);
        $this->fieldType = self::TYPE_TEXT;
        $this->inputValue = $inputValue;
    }

    public function email() {
        $this->fieldType = self::TYPE_EMAIL;
        return $this;
    }

    public function number() {
        $this->fieldType = self::TYPE_NUMBER;
        return $this;
    }

    public function password() {
        $this->fieldType = self::TYPE_PASSWORD;
        return $this;
    }

    public function renderInput(): string {
        $value = empty($this->model->{$this->attribute})? $this->inputValue : $this->model->{$this->attribute};
        $errorClass = $this->model->hasError($this->attribute) ? 'is-invalid' : '';

        return "
            <input type='$this->fieldType' name='$this->attribute' value='$value' class='form-control $errorClass'/>
        ";
    }
}