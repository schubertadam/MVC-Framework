<?php

namespace App\Helpers\Form;

use App\Core\Model;

abstract class Field
{
    protected Model $model;
    protected string $attribute;

    public function __construct(Model $model, string $attribute) {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    abstract public function renderInput(): string;

    public function __toString() {
        $label = $this->model->label()[$this->attribute] ?? ucfirst($this->attribute);
        $input = $this->renderInput();
        $errorMessage = $this->model->getFirstError($this->attribute);

        return "
            <div class='mb-3'>
                <label for='$this->attribute' class='form-label'>$label</label>
                $input        
                <div class='invalid-feedback'>$errorMessage</div>
            </div>
        ";
    }
}