<?php

namespace entities;
use helpers\PluralForm;


class TypeAmountRoom extends Entity
{
    public function __construct($id) {
        $this->id = $id;
        $this->name = $this->id . ' ' . PluralForm::plural(['комната', 'комнаты', 'комнат'], $this->id);
    }
}