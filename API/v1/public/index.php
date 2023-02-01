<?php

/** Quelle: https://www.php.net/manual/en/function.set-error-handler.php
 * error handler function, does not clear Criticl errors
 */
function customError($errno, $errstr)
{
    echo "";
}

//set error handler
//set_error_handler("customError");

// this handel the request and response.
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// This allows to Using Slim and build our application.
use Slim\Factory\AppFactory;

// all the libraries we need.
require __DIR__ . "/../vendor/autoload.php";
// self made functions
require_once "Controler/validation.php";
require_once "Controler/error-and-info-messages.php";
require_once "Model/SQL.php";

// all response data will be in the Json Fromat
header("Content-Type: application/json");

$app = AppFactory::create();

$app->setBasePath("/API/v1");

/**
 * This will work
 * @param args 
 * @param request_body 
 * @return response 
 */
$app->post("/Login", function (Request $request, Response $response, $args) {

    // reads the requested JSON body
    $body_content = file_get_contents("php://input");
    $JSON_data = json_decode($body_content, true);

    // if JSON data doesn't have these then there is an error
    if (isset($JSON_data["username"]) && isset($JSON_data["password"])) {
    } else {
        error_function(400, "Empty request");
    }

    // Prepares the data to prevent bad data, SQL injection andCross site scripting
    $username = validate_string($JSON_data["username"]);
    $password = validate_string($JSON_data["password"]);

        if (!$password) {
            error_function(400, "password is invalid, must contain at least 5 characters");
        }
        if (!$username) {
            error_function(400, "username is invalid, must contain at least 5 characters");
        }

    $password = hash("sha256", $password);

    $user = get_user_by_username($username);

    if ($user["Password"] !==  $password) {
        error_function(404, "not Found");
    }

    $token = create_token($username, $password, $user["ID"]);

    setcookie("token", $token);

    message_function(200, "Succesfuly created Token");

    return $response;
});

function user_validation()
{
    $current_user = validate_token();
    if ($current_user === false) {
        error_function(403, "unauthenticated");
    }
    return $current_user;
}

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
            require_once "clients/list.php";
            echo json_encode(get_all_clients(true));
            die();
        } else if ($user["Usertype"] === "U") {
            require_once "clients/list.php";
            echo json_encode(get_all_clients(false));
            die();
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
            require_once "clients/read.php";
            echo json_encode(get_client_by_id($user_id, true));
            die();
        } else if ($user["Usertype"] === "U") {
            require_once "clients/read.php";
            echo json_encode(get_client_by_id($user_id, false));
            die();
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

    $sex = validate_string($JSON_data["Sex"]);
    $name = validate_string($JSON_data["Name"]);
    $surname = validate_string($JSON_data["Surname"]);
    $street = validate_string($JSON_data["Street"]);
    $postcode = validate_string($JSON_data["Postcode"]);
    $city = validate_string($JSON_data["City"]);
    $billingaddress = validate_number($JSON_data["billingAddress"]);
    $phonenumber_company = validate_string($JSON_data["phonenumberCompany"]);
    $phonenumber_private = validate_string($JSON_data["phonenumberPrivate"]);
    $email = validate_string($JSON_data["email"]);
    $join_date = validate_string($JSON_data["joinDate"]);
    $vip = validate_boolean($JSON_data["VIP"]);
    $high_frequenz = validate_boolean($JSON_data["highFrequency"]);
    $credit_rating = validate_string($JSON_data["creditRating"]);
    $debt = validate_number($JSON_data["debt"]);
    $creditcard = validate_boolean($JSON_data["creditcard"]);
    $bill = validate_boolean($JSON_data["bill"]);
    $prepayement = validate_boolean($JSON_data["prepayment"]);

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
    if (!$postcode) {
        error_function(400, "postcode is invalid, must contain at least 1 character");
    }
    if (!$city) {
        error_function(400, "city is invalid, must contain at least 1 character");
    }
    if (!$billingaddress && $billingaddress !== 0) {
        error_function(400, "billingaddress is not set");
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
    if (!isset($vip)) {
        error_function(400, "vip is not set");
    }
    if (!isset($high_frequenz)) {
        error_function(400, "high frequenz is not set");
    }
    if (!isset($credit_rating)) {
        error_function(400, "creadit rating is invalid, must contain at least 1 characters");
    }
    if (!isset($debt)) {
        error_function(400, "debt is not set");
    }
    if (!isset($creditcard)) {
        error_function(400, "creditcard is not set");
    }
    if (!isset($bill)) {
        error_function(400, "image is not set");
    }
    if (!isset($prepayement)) {
        error_function(400, "prepayement is not set");
    }

    require_once "clients/create.php";

    create_client($sex, $name, $surname, $street, $postcode, $city, $billingaddress, $phonenumber_company, $phonenumber_private, $email, $vip, $high_frequenz, $credit_rating, $debt, $creditcard, $bill, $prepayement);

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

    require_once "clients/delete.php";
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

    $sex = validate_string($JSON_data["Sex"]);
    $name = validate_string($JSON_data["Name"]);
    $surname = validate_string($JSON_data["Surname"]);
    $street = validate_string($JSON_data["Street"]);
    $postcode = validate_string($JSON_data["Postcode"]);
    $city = validate_string($JSON_data["City"]);
    $billingaddress = validate_number($JSON_data["billingAddress"]);
    $phonenumber_company = validate_string($JSON_data["phonenumberCompany"]);
    $phonenumber_private = validate_string($JSON_data["phonenumberPrivate"]);
    $email = validate_string($JSON_data["email"]);
    $join_date = validate_string($JSON_data["joinDate"]);
    $vip = validate_boolean($JSON_data["VIP"]);
    $high_frequenz = validate_boolean($JSON_data["highFrequency"]);
    $credit_rating = validate_string($JSON_data["creditRating"]);
    $debt = validate_number($JSON_data["debt"]);
    $creditcard = validate_boolean($JSON_data["creditcard"]);
    $bill = validate_boolean($JSON_data["bill"]);
    $prepayement = validate_boolean($JSON_data["prepayment"]);

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
    if (!$postcode) {
        error_function(400, "postcode is invalid, must contain at least 1 character");
    }
    if (!$city) {
        error_function(400, "city is invalid, must contain at least 1 character");
    }
    if (!isset($billingaddress)) {
        error_function(400, "billingaddress is not set");
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
    if (!isset($vip)) {
        error_function(400, "vip is not set");
    }
    if (!isset($high_frequenz)) {
        error_function(400, "high frequenz is not set");
    }
    if (!isset($credit_rating)) {
        error_function(400, "creadit rating is invalid, must contain at least 1 characters");
    }
    if (!isset($debt)) {
        error_function(400, "debt is not set");
    }
    if (!isset($creditcard)) {
        error_function(400, "creditcard is not set");
    }
    if (!isset($bill)) {
        error_function(400, "image is not set");
    }
    if (!isset($prepayement)) {
        error_function(400, "prepayement is not set");
    }

    $user_id = validate_string($args["user_id"]);

    require_once "clients/update.php";

    change_client_data($user_id, $sex, $name, $surname, $street, $postcode, $city, $billingaddress, $phonenumber_company, $phonenumber_private, $email, $vip, $high_frequenz, $credit_rating, $debt, $creditcard, $bill, $prepayement);

    return $response;
});


$app->run();
