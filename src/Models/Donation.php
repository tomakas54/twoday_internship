<?php

namespace Models;

class Donation {
    private $id;
    private $donorName;
    private $amount;
    private $charityId;
    private $dateTime;

    public function __construct($id, $donorName, $amount, $charityId, $dateTime) {
        $this->setId($id);
        $this->setDonorName($donorName);
        $this->setAmount($amount);
        $this->setCharityId($charityId);
        $this->setDateTime($dateTime);
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

    public function getDonorName() {
        return $this->donorName;
    }

    public function setDonorName($donorName) {
        if (is_string($donorName) && !empty(trim($donorName))) {
            $this->donorName = $donorName;
        } else {
            throw new \InvalidArgumentException("Donor name must be a non-empty string.");
        }
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        if (is_numeric($amount) && $amount > 0) {
            $this->amount = $amount;
        } else {
            throw new \InvalidArgumentException("Amount must be a positive number.");
        }
    }

    public function getCharityId() {
        return $this->charityId;
    }

    public function setCharityId($charityId) {
        $this->charityId = $charityId;
    }

    public function getDateTime() {
        return $this->dateTime;
    }

    public function setDateTime($dateTime) {
        $parsedDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $dateTime);
        if ($parsedDateTime && $parsedDateTime->format('Y-m-d H:i:s') === $dateTime) {
            $this->dateTime = $dateTime;
        } else {
            throw new \InvalidArgumentException("Date/time format must be 'Y-m-d H:i:s'.");
        }
    }

    public function isValidAmount() {
        return is_numeric($this->amount) && $this->amount > 0;
    }

    public function isValidDateTime() {
        $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $this->dateTime);
        return $dateTime && $dateTime->format('Y-m-d H:i:s') === $this->dateTime;
    }
}
