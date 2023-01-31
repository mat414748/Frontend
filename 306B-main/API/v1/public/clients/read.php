<?php
    /**
     * Gets The client by the Id. If the user has the Privlige they can view VIP Clients
     */
	function get_client_by_id($client_id, $privlige) {
        $database = new mysqli("localhost", "root", "", "306b");

        $result = false;

        if ($privlige) {
            $result = $database->query("SELECT * FROM clients WHERE ID = '$client_id';");
        } else {
            $result = $database->query("SELECT * FROM clients WHERE ID = '$client_id' AND vip = false ;");
        }

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
