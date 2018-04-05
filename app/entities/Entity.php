<?php

namespace entities;


abstract class Entity {
    protected $name;
    protected $id;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function getId() {
        return $this->id;
    }
}