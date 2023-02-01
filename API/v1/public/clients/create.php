<?php
    /**
     * This Function Searches if the Given Parameters Don't Alredy Exist in a client.
     * If all is Original Data Then it will create the New Client
     */
    function create_client($sex, $name, $surname, $street, $postcode, $city, $billingaddress, $phonenumber_company, $phonenumber_private, $email, $vip, $high_frequenz, $credit_rating, $debt, $creditcard, $bill, $prepayement) {
        $database = new mysqli("localhost", "root", "", "306b");

        $result = false;

        if (isset($name) && isset($surname) && isset($street) && isset($postcode) && isset($city)) {
            $result = $database->query("SELECT * FROM clients WHERE Name = \"" . $name . "\" AND Surname = \"" . $surname . "\" AND Street = \"" . $street . "\" AND Postcode = \"" . $postcode . "\" AND City = \"" . $city . "\";");
            if ($result !== true) {
                if ($result->num_rows > 0) {
                    error_function(404, "Address Alredy Exists");
                }
            }
        }
        if (isset($phonenumber_company)) {
            $result = $database->query("SELECT * FROM clients WHERE 'Phonenumber Company' = \"" . $phonenumber_company . "\";");
            if ($result !== true) {
                if ($result->num_rows > 0) {
                    error_function(404, "company phonenumber Alredy Exists");
                }
            }
        }
        if (isset($phonenumber_private)) {
            $result = $database->query("SELECT * FROM clients WHERE 'Phonenumber Private' = \"" . $phonenumber_private . "\";");
            if ($result !== true) {
                if ($result->num_rows > 0) {
                    error_function(404, "private phonenumber Alredy Exists");
                }
            }
        }
        if (isset($email)) {
            $result = $database->query("SELECT * FROM clients WHERE 'E-Mail' = \"" . $email . "\";");
            if ($result !== true) {
                if ($result->num_rows > 0) {
                    error_function(404, "Mail Alredy Exists");
                }
            }
        }
        $billCreate = $database->query("INSERT INTO billingadress (Name, Surname, Street, Postcode, City) VALUES ('$name', '$surname', '$street', '$postcode', '$city')");
        $result = $database->query("INSERT INTO clients (Sex, Name, Surname, Street, Postcode, City, `Billing Address`, `Phonenumber Company`, `Phonenumber Private`, `E-Mail`, VIP, `High frequency`, `Credit Rating`, Debt, Creditcard, Bill, Prepayment ) VALUES ('$sex', '$name', '$surname', '$street', '$postcode', '$city', (SELECT ID FROM `billingadress` WHERE Street='$street'), '$phonenumber_company', '$phonenumber_private', '$email', '$vip', '$high_frequenz', '$credit_rating', '$debt', '$creditcard', '$bill', '$prepayement')");
        if ($result == true) {
            message_function(201, "Succesfuly Created");
		}

        error_function(401, "not Created");
    };
?>