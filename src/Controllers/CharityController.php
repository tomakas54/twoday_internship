<?php

namespace Controllers;

use Models\Charity;

class CharityController {
    private $charities = [];

    public function addCharity($id, $name, $email) {
        if ($this->isIdDuplicate($id)) {
            echo "Charity with ID: $id already exists.\n";
            return;
        }

        try {
            $charity = new Charity($id, $name, $email);
            $this->charities[] = $charity;
            echo "Charity added successfully.\n";
        } catch (\InvalidArgumentException $e) {
            echo $e->getMessage() . "\n";
        }
    }

    private function isIdDuplicate($id) {
        foreach ($this->charities as $charity) {
            if ($charity->getId() === $id) {
                return true;
            }
        }
        return false;
    }

    public function viewCharities() {
        foreach ($this->charities as $charity) {
            echo "ID: {$charity->getId()}, Name: {$charity->getName()}, Email: {$charity->getEmail()}\n";
        }
    }

    public function editCharity($id, $newName, $newEmail) {
        foreach ($this->charities as $charity) {
            if ($charity->getId() === $id) {
                $updateOccurred = false;

                if (!empty(trim($newEmail))) {
                    if ($charity->isValidEmail($newEmail)) {
                        $charity->setEmail($newEmail);
                        $updateOccurred = true;
                    } else {
                        echo "Invalid email format.\n";
                    }
                }

                if (!empty(trim($newName))) {
                    $charity->setName($newName);
                    $updateOccurred = true;
                }
                if ($updateOccurred) {
                    echo "Charity updated successfully.\n";
                }
                return;
            }
        }
        echo "Charity not found.\n";
    }

    public function deleteCharity($id) {
        foreach ($this->charities as $index => $charity) {
            if ($charity->getId() === $id) {
                unset($this->charities[$index]);
                echo "Charity deleted successfully.\n";
                return;
            }
        }
        echo "Charity not found.\n";
    }

    public function charityExists($charityId) {
        foreach ($this->charities as $charity) {
            if ($charity->getId() === $charityId) {
                return true;
            }
        }
        return false;
    }
}
