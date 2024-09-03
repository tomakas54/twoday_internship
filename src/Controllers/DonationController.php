<?php

namespace Controllers;

use Models\Donation;
use InvalidArgumentException;

class DonationController {
    private $donations = [];
    private $charityController;

    public function __construct(CharityController $charityController) {
        $this->charityController = $charityController;
    }

    public function addDonation($id, $donorName, $amount, $charityId, $dateTime) {
        try {
            if (!$this->charityController->charityExists($charityId)) {
                throw new \Exception("Charity with ID: $charityId does not exist.");
            }

            if ($this->isIdDuplicate($id)) {
                throw new \Exception("Donation with ID: $id already exists.");
            }

            if (empty(trim($dateTime))) {
                $dateTime = date('Y-m-d H:i:s');
            }

            $donation = new Donation($id, $donorName, $amount, $charityId, $dateTime);
            
            if (!$donation->isValidAmount()) {
                throw new \InvalidArgumentException("Invalid donation amount. It must be a positive number.");
            }
            
            if (!$donation->isValidDateTime()) {
                throw new \InvalidArgumentException("Invalid date/time format. Use 'Y-m-d H:i:s'.");
            }

            $this->donations[] = $donation;
            echo "Donation added successfully.\n";
        } catch (\InvalidArgumentException $e) {
            echo $e->getMessage() . "\n";
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }

    public function viewDonations($charityId) {
        $foundDonations = array_filter($this->donations, function($donation) use ($charityId) {
            return $donation->getCharityId() === $charityId;
        });

        if (empty($foundDonations)) {
            echo "No donations found for charity ID: $charityId.\n";
            return;
        }

        foreach ($foundDonations as $donation) {
            echo "Donation ID: " . $donation->getId() . "\n";
            echo "Donor Name: " . $donation->getDonorName() . "\n";
            echo "Amount: $" . number_format($donation->getAmount(), 2) . "\n";
            echo "Date/Time: " . $donation->getDateTime() . "\n";
            echo "----------------------------------\n";
        }
    }

    private function isIdDuplicate($id) {
        foreach ($this->donations as $donation) {
            if ($donation->getId() === $id) {
                return true;
            }
        }
        return false;
    }
}
