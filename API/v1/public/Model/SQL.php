<?php
    require_once "sql-db-conection.php";

    function get_user_by_id($id) {
        global $database;

        $result = $database->query("SELECT * FROM user WHERE ID = \"" . $id . "\";");

        if ($result == false) {
            error_function(500, "Error");
		} else if ($result !== true) {
			if ($result->num_rows > 0) {
                return $result->fetch_assoc();
			} else {
                error_function(404, "not Found");
            }
		} else {
            error_function(404, "not Found");
        }
    }

    function get_user_by_username($name) {
        global $database;

        $result = $database->query("SELECT * FROM user WHERE Username = \"" . $name . "\";");

        if ($result == false) {
            error_function(500, "Error");
		} else if ($result !== true) {
			if ($result->num_rows > 0) {
                return $result->fetch_assoc();
			} else {
                error_function(404, "not Found");
            }
		} else {
            error_function(404, "not Found");
        }
    }

?>
