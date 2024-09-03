<?php

namespace Models;

class Charity {
    private $id;
    private $name;
    private $email;

    public function __construct($id, $name, $email) {
        $this->setId($id);
        $this->setName($name);
        $this->setEmail($email);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if ($this->isValidId($id)) {
            $this->id = $id;
        } else {
            throw new \InvalidArgumentException("Invalid ID: ID should be a positive number.");
        }
    }

    private function isValidId($id) {
        return is_numeric($id) && $id > 0;
    }
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        if ($this->isValidName($name)) {
            $this->name = $name;
        } else {
            throw new \InvalidArgumentException("Name cannot be empty.");
        }
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        if ($this->isValidEmail($email)) {
            $this->email = $email;
        } else {
            throw new \InvalidArgumentException("Invalid email format.");
        }
    }

    public function isValidEmail($email = null) {
        $email = $email ?: $this->email;
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function isValidName($name = null) {
        $name = $name ?: $this->name;
        return !empty(trim($name));
    }
}
