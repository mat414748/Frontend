<?php

	/**
     * This Function Searches if the Given Parameters Don't Alredy Exist in a client But Will Filter out The Client that will be changed.
     * If all is Original Data Then it will change the Clients Data
     */
	function change_client_data($client_id, $sex, $name, $surname, $street, $postcode, $city, $billingaddress, $phonenumber_company, $phonenumber_private, $email, $vip, $high_frequenz, $credit_rating, $debt, $creditcard, $bill, $prepayement) {
        $database = new mysqli("localhost", "root", "", "306b");

		$result = false;

        if (isset($name) && isset($surname)) {
            $result = $database->query("SELECT * FROM clients WHERE Name = \"$name\" AND surname = \"$surname\" AND NOT ID = '$client_id';");
            if ($result !== true) {
                if ($result->num_rows > 0) {
                    error_function(404, "name Alredy Exists");
                }
            }
        }
        if (isset($street) && isset($postcode) && isset($city)) {
            $result = $database->query("SELECT * FROM clients WHERE Street = \"$street\" AND Postcode = \"$postcode\" AND City = \"$city\" AND NOT ID = '$client_id';");
            if ($result !== true) {
                if ($result->num_rows > 0) {
                    error_function(404, "Location Alredy Exists");
                }
            }
        }
        if (isset($phonenumber_company)) {
            $result = $database->query("SELECT * FROM clients WHERE 'Phonenumber Company' = \"$phonenumber_company\" AND NOT ID = '$client_id';");
            if ($result !== true) {
                if ($result->num_rows > 0) {
                    error_function(404, "company phonenumber Alredy Exists");
                }
            }
        }
        if (isset($phonenumber_private)) {
            $result = $database->query("SELECT * FROM clients WHERE 'Phonenumber Private' = \"$phonenumber_private\" AND NOT ID = '$client_id';");
            if ($result !== true) {
                if ($result->num_rows > 0) {
                    error_function(404, "private phonenumber Alredy Exists");
                }
            }
        }
        if (isset($email)) {
            $result = $database->query("SELECT * FROM clients WHERE 'E-Mail' = \"$email\" AND NOT ID = '$client_id';");
            if ($result !== true) {
                if ($result->num_rows > 0) {
                    error_function(404, "Mail Alredy Exists");
                }
            }
        }
        //, Billingaddress = '$billingaddress', 'Phonenumber Company' = '$phonenumber_company', 'Phonenumber Private' = '$phonenumber_private', E-Mail = '$email', Vip = '$vip', 'High Frequenz' = '$high_frequenz', 'Credit Rating' = '$credit_rating', Debt = '$debt', Creditcard = '$creditcard', Bill = '$bill', Prepayement = '$prepayement'
        $result = $database->query("UPDATE clients SET Sex = '$sex', Name = '$name', Surname = '$surname', Street = '$street', Postcode = '$postcode', City = '$city' WHERE ID = $client_id");
        if ($result == true) {
            message_function(201, "Succesfuly Created");
		}

        error_function(401, "not Changed");
	}
?>
