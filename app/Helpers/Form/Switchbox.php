<?php

namespace App\Helpers\Form;

use App\Core\Model;

class Switchbox extends Field
{
    public function __construct(Model $model, string $attribute) {
        parent::__construct($model, $attribute);
    }

    public function renderInput(): string {
        $labelId = $this->attribute . 'Label';

        return "
            <div class='form-check form-switch'>
                <input type='checkbox' class='form-check-input' id='$this->attribute' name='$this->attribute' checked>
                <label class='form-check-label' for='$this->attribute' id='$labelId'></label>
            </div>
        ";
    }
}