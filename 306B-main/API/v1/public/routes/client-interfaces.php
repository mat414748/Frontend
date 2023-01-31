<?php

    require_once "Controler/validation.php";
    require_once "Controler/error-and-info-messages.php";
    require_once "Model/SQL.php";

    /**
     * User validation will check what privlige you have and if you are even Loged in
     * This will either return all normal clients or if the user is a Admin or key user this will return VIP and normal clients
     * @return response A array of client data
     */
    $app->get("/Clients", function (Request $request, Response $response, $args) {
        $current_user = user_validation();

        $user = get_user_by_id($current_user);
        if ($user["Usertype"] === "A" || $user["Usertype"] === "K") {
            require_once "../clients/list.php";
            echo get_all_clients(true);
        } else if ($user["Usertype"] === "U") {
            require_once "../clients/list.php";
            echo get_all_clients(false);
        }
        error_function(403, "unauthenticated");
        return $response;
    });

    /**
     * User validation will check what privlige you have and if you are even Loged in
     * This will either return all normal clients or if the user is a Admin or key user this will return VIP and normal clients
     * @return response A array of client data
     */
    $app->get("/Oneclient/{user_id}", function (Request $request, Response $response, $args) {
        $current_user = user_validation();

        $user_id = validate_number($args["user_id"]);

        $user = get_user_by_id($current_user);
        if ($user["Usertype"] === "A" || $user["Usertype"] === "K") {
            require_once "../clients/read.php";
            echo get_client_by_id($user_id, true);
        } else if ($user["Usertype"] === "U") {
            require_once "../clients/read.php";
            echo get_client_by_id($user_id, false);
        }
        error_function(403, "unauthenticated");
        return $response;
    });

    /**
     * User validation will check what privlige you have and if you are even Loged in
     * this will only return a confirmation or a error message
     * @param php://input a JSON object with all client information
     * @return response true or error
     */
    $app->post("/Client", function (Request $request, Response $response, $args) {
        $current_user = user_validation();

        $user = get_user_by_id($current_user);
        if ($user["Usertype"] !== "A") {
            error_function(403, "No Acces");
        }

        // reads the requested JSON body
        $body_content = file_get_contents("php://input");
        $JSON_data = json_decode($body_content, true);

       if (isset($JSON_data["sex"]) && isset($JSON_data["name"]) && isset($JSON_data["name"]) && isset($JSON_data["surname"]) && isset($JSON_data["street"]) && isset($JSON_data["postcode"]) && isset($JSON_data["city"]) && isset($JSON_data["billingaddress"]) && isset($JSON_data["phonenumber_company"]) && isset($JSON_data["phonenumber_private"]) && isset($JSON_data["email"]) && isset($JSON_data["join_date"]) && isset($JSON_data["vip"]) && isset($JSON_data["high_frequenz"]) && isset($JSON_data["creadit_rating"]) && isset($JSON_data["debt"]) && isset($JSON_data["creditcard"]) && isset($JSON_data["bill"]) && isset($JSON_data["prepayement"])) { } else {
           error_function(400, "Empty request");
       }

       $sex = validate_string($JSON_data["sex"]);
       $name = validate_string($JSON_data["name"]);
       $surname = validate_string($JSON_data["surname"]);
       $street = validate_string($JSON_data["street"]);
       $postcode = validate_string($JSON_data["postcode"]);
       $city = validate_string($JSON_data["city"]);
       $billingaddress = validate_number($JSON_data["billingaddress"]);
       $phonenumber_company = validate_string($JSON_data["phonenumber_company"]);
       $phonenumber_private = validate_string($JSON_data["phonenumber_private"]);
       $email = validate_string($JSON_data["email"]);
       $join_date = validate_string($JSON_data["join_date"]);
       $vip = validate_boolean($JSON_data["vip"]);
       $high_frequenz = validate_boolean($JSON_data["high_frequenz"]);
       $credit_rating = validate_string($JSON_data["credit_rating"]);
       $debt = validate_number($JSON_data["debt"]);
       $creditcard = validate_boolean($JSON_data["creditcard"]);
       $bill = validate_boolean($JSON_data["bill"]);
       $prepayement = validate_boolean($JSON_data["prepayement"]);

       if (!$sex) {
           error_function(400, "sex is invalid, must contain at least 8 characters");
       }
       if (!$name) {
            error_function(400, "name is invalid, must contain at least 1 character");
        }
        if (!$surname) {
            error_function(400, "surname is invalid, must contain at least 1 character");
        }
        if (!$street) {
            error_function(400, "street is invalid, must contain at least 1 character");
        }
        if (!$postocde) {
            error_function(400, "postcode is invalid, must contain at least 1 character");
        }
        if (!$city) {
            error_function(400, "city is invalid, must contain at least 1 character");
        }
       if (!$billingaddress) {
        error_function(400, "billingaddress is invalid");
        }
        if (!$phonenumber_company) {
            error_function(400, "company phonenumber is invalid, must contain at least 1 characters");
        }
        if (!$phonenumber_private) {
            error_function(400, "private phonenumber is invalid, must contain at least 1 characters");
        }
        if (!$email) {
            error_function(400, "email is invalid, must contain at least 1 characters");
        }
        if (!$vip) {
            error_function(400, "vip is not set");
        }
        if (!$high_frequenz) {
            error_function(400, "high frequenz is invalid, must contain at least 1 characters");
        }
        if (!$credit_rating) {
            error_function(400, "creadit rating is invalid, must contain at least 1 characters");
        }
        if (!$debt) {
            error_function(400, "debt is invalid, must contain at least 1 characters");
        }
        if (!$creditcard) {
            error_function(400, "creditcard is not set");
        }
        if (!$bill) {
            error_function(400, "image is not set");
        }
        if (!$prepayement) {
            error_function(400, "prepayement is not set");
        }

        require_once "../clients/create.php";

        create_client($sex, $name, $surname, $street, $postocde, $city, $billingaddress, $phonenumber_company, $phonenumber_private, $email, $vip, $high_frequenz, $credit_rating, $debt, $creditcard, $bill, $prepayement);
        
        return $response;
    });

    /**
     * User validation will check what privlige you have and if you are even Loged in
     * this will only return a confirmation or a error message
     * @param args["id"] this will decide what client will be deleted
     * @return response true or error
     */
    $app->delete("/Client/{user_id}", function (Request $request, Response $response, $args) {
        $current_user = user_validation();

        $user = get_user_by_id($current_user);
        if ($user["Usertype"] !== "A") {
            error_function(403, "unauthenticated");
        }
        
        $user_id = validate_number($args["user_id"]);

        require_once "../clients/delete.php";
        get_client_by_id($user_id);

        return $response;
    });

    /**
     * User validation will check what privlige you have and if you are even Loged in
     * this will only return a confirmation or a error message
     * @param args["id"] this will decide what client will be mutated
     * @param php://input a JSON object with all client information
     * @return response true or error
     */
    $app->put("/Client/{user_id}", function (Request $request, Response $response, $args) {
        $current_user = user_validation();

        $user = get_user_by_id($current_user);
        if ($user["Usertype"] !== "A") {
            error_function(403, "unauthenticated");
        }

        // reads the requested JSON body
        $body_content = file_get_contents("php://input");
        $JSON_data = json_decode($body_content, true);

        if (isset($JSON_data["sex"]) && isset($JSON_data["name"]) && isset($JSON_data["name"]) && isset($JSON_data["surname"]) && isset($JSON_data["street"]) && isset($JSON_data["postcode"]) && isset($JSON_data["city"]) && isset($JSON_data["billingaddress"]) && isset($JSON_data["phonenumber_company"]) && isset($JSON_data["phonenumber_private"]) && isset($JSON_data["email"]) && isset($JSON_data["join_date"]) && isset($JSON_data["vip"]) && isset($JSON_data["high_frequenz"]) && isset($JSON_data["creadit_rating"]) && isset($JSON_data["debt"]) && isset($JSON_data["creditcard"]) && isset($JSON_data["bill"]) && isset($JSON_data["prepayement"])) { } else {
            error_function(400, "Empty request");
        }
 
        $sex = validate_string($JSON_data["sex"]);
        $name = validate_string($JSON_data["name"]);
        $surname = validate_string($JSON_data["surname"]);
        $street = validate_string($JSON_data["street"]);
        $postcode = validate_string($JSON_data["postcode"]);
        $city = validate_string($JSON_data["city"]);
        $billingaddress = validate_number($JSON_data["billingaddress"]);
        $phonenumber_company = validate_string($JSON_data["phonenumber_company"]);
        $phonenumber_private = validate_string($JSON_data["phonenumber_private"]);
        $email = validate_string($JSON_data["email"]);
        $join_date = validate_string($JSON_data["join_date"]);
        $vip = validate_boolean($JSON_data["vip"]);
        $high_frequenz = validate_boolean($JSON_data["high_frequenz"]);
        $credit_rating = validate_string($JSON_data["credit_rating"]);
        $debt = validate_number($JSON_data["debt"]);
        $creditcard = validate_boolean($JSON_data["creditcard"]);
        $bill = validate_boolean($JSON_data["bill"]);
        $prepayement = validate_boolean($JSON_data["prepayement"]);
 
        if (!$sex) {
            error_function(400, "sex is invalid, must contain at least 8 characters");
        }
        if (!$name) {
             error_function(400, "name is invalid, must contain at least 1 character");
         }
         if (!$surname) {
             error_function(400, "surname is invalid, must contain at least 1 character");
         }
         if (!$street) {
             error_function(400, "street is invalid, must contain at least 1 character");
         }
         if (!$postocde) {
             error_function(400, "postcode is invalid, must contain at least 1 character");
         }
         if (!$city) {
             error_function(400, "city is invalid, must contain at least 1 character");
         }
        if (!$billingaddress) {
         error_function(400, "billingaddress is invalid");
         }
         if (!$phonenumber_company) {
             error_function(400, "company phonenumber is invalid, must contain at least 1 characters");
         }
         if (!$phonenumber_private) {
             error_function(400, "private phonenumber is invalid, must contain at least 1 characters");
         }
         if (!$email) {
             error_function(400, "email is invalid, must contain at least 1 characters");
         }
         if (!$vip) {
             error_function(400, "vip is not set");
         }
         if (!$high_frequenz) {
             error_function(400, "high frequenz is invalid, must contain at least 1 characters");
         }
         if (!$credit_rating) {
             error_function(400, "creadit rating is invalid, must contain at least 1 characters");
         }
         if (!$debt) {
             error_function(400, "debt is invalid, must contain at least 1 characters");
         }
         if (!$creditcard) {
             error_function(400, "creditcard is not set");
         }
         if (!$bill) {
             error_function(400, "image is not set");
         }
         if (!$prepayement) {
             error_function(400, "prepayement is not set");
         }

        $user_id = validate_string($args["user_id"]);

        require_once "../clients/update.php";

        change_client_data($user_id, $sex, $name, $surname, $street, $postocde, $city, $billingaddress, $phonenumber_company, $phonenumber_private, $email, $vip, $high_frequenz, $credit_rating, $debt, $creditcard, $bill, $prepayement);
        
        return $response;
    });

?>
