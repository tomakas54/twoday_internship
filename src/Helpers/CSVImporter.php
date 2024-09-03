<?php

namespace Helpers;

use Controllers\CharityController;

class CSVImporter {
    private $charityController;

    public function __construct(CharityController $charityController) {
        $this->setCharityController($charityController);
    }

    // Getter for $charityController
    public function getCharityController() {
        return $this->charityController;
    }

    // Setter for $charityController
    public function setCharityController(CharityController $charityController) {
        $this->charityController = $charityController;
    }

    public function importFromCSV($filePath) {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            echo "File does not exist or is not readable.\n";
            return;
        }

        if (($handle = fopen($filePath, 'r')) !== false) {
            $header = fgetcsv($handle); // Get header row

            while (($data = fgetcsv($handle)) !== false) {
                // Assuming the CSV columns are: id, name, email
                $id = $data[0];
                $name = $data[1];
                $email = $data[2];

                if (empty($id) || empty($name) || empty($email)) {
                    echo "Invalid data in CSV. Skipping row.\n";
                    continue;
                }

                // Add charity to the CharityController using the getter
                $this->getCharityController()->addCharity($id, $name, $email);
            }
            fclose($handle);
            echo "CSV import completed successfully.\n";
        } else {
            echo "Error opening CSV file.\n";
        }
    }
}
