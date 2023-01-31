<?php
    /**
     * From The Client_id it will remove the client
     */
	function get_client_by_id($client_id) {
        $database = new mysqli("localhost", "root", "", "306b");

        $result = $database->query("DELETE FROM clients WHERE ID = '$client_id';");

        if ($result == true) {
            message_function(201, "Succesfuly Deleted");
		}
        error_function(401, "not Changed");
    }
?>
