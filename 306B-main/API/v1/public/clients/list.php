<?php
    /**
     * Gets All The client. If the user has the Privlige they can View VIP Clients
     */
	function get_all_clients($privlige) {
        $database = new mysqli("localhost", "root", "", "306b");

        $result = false;

        if ($privlige) {
            $result = $database->query("SELECT * FROM clients;");
        } else {
            $result = $database->query("SELECT * FROM clients WHERE vip = false ;");
        }

        if ($result == false) {
            error_function(500, "Error");
		} else if ($result !== true) {
			if ($result->num_rows > 0) {
                $result_array = array();
				while ($user = $result->fetch_assoc()) {
                    $result_array[] = $user;
                }
                return $result_array;
			} else {
                error_function(404, "not Found");
            }
		}
        error_function(404, "not Found");
    }
?>