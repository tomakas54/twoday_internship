<?php

require_once 'src/Models/Charity.php';
require_once 'src/Models/Donation.php';
require_once 'src/Controllers/CharityController.php';
require_once 'src/Controllers/DonationController.php';
require_once 'src/Helpers/CSVImporter.php';

use Controllers\CharityController;
use Controllers\DonationController;
use Helpers\CSVImporter;

$charityController = new CharityController();
$donationController = new DonationController($charityController);
$csvImporter = new CSVImporter($charityController);

echo "Charity Management CLI Application\n";
echo "1. View Charities\n";
echo "2. Add Charity\n";
echo "3. Edit Charity\n";
echo "4. Delete Charity\n";
echo "5. Add Donation\n";
echo "6. View Donations\n";
echo "7. Import Charities from CSV\n";
echo "8. Exit\n";

do {
    echo "\nChoose an option: ";
    $option = trim(fgets(STDIN));

    switch ($option) {
        case 1:
            $charityController->viewCharities();
            break;
        case 2:
            echo "Enter ID: ";
            $id = trim(fgets(STDIN));
            echo "Enter Name: ";
            $name = trim(fgets(STDIN));
            echo "Enter Email: ";
            $email = trim(fgets(STDIN));
            $charityController->addCharity($id, $name, $email);
            break;
        case 3:
            echo "Enter Charity ID to Edit: ";
            $id = trim(fgets(STDIN));
            echo "Enter New Name: ";
            $newName = trim(fgets(STDIN));
            echo "Enter New Email: ";
            $newEmail = trim(fgets(STDIN));
            $charityController->editCharity($id, $newName, $newEmail);
            break;
        case 4:
            echo "Enter Charity ID to Delete: ";
            $id = trim(fgets(STDIN));
            $charityController->deleteCharity($id);
            break;
        case 5:
            echo "Enter Donation ID: ";
            $id = trim(fgets(STDIN));
            echo "Enter Donor Name: ";
            $donorName = trim(fgets(STDIN));
            echo "Enter Amount: ";
            $amount = trim(fgets(STDIN));
            echo "Enter Charity ID: ";
            $charityId = trim(fgets(STDIN));
            echo "Enter Date Time (Y-m-d H:i:s): ";
            $dateTime = trim(fgets(STDIN));
            $donationController->addDonation($id, $donorName, $amount, $charityId, $dateTime);
            break;
        case 6:
            echo "Enter Charity ID to View Donations: ";
            $charityId = trim(fgets(STDIN));
            $donationController->viewDonations($charityId);
            break;
        case 7:
            echo "Enter CSV file path: ";
            $filePath = trim(fgets(STDIN));
            $csvImporter->importFromCSV($filePath);
            break;
        case 8:
            echo "Goodbye!\n";
            exit;
        default:
            echo "Invalid option. Please try again.\n";
            break;
    }
} while (true);
