<?php
// Trait that handles endpoint operations
trait FormHandling {
    // Echoes a response and kills the running script
    function response($response, $json = null) {
        if ($json) {
            $json_array = array(
                "response" => $response,
                "data"     => $json
            );
            echo json_encode($json_array);
        }
        else {
            echo $response;
        }
        die();
    }
    // Checks if a value matches the regular expression of the giveen property
    function validatePattern($key, $value) {
        if (!preg_match($this->getPattern($key), $value)) {
            $this->response("INVALID_" . strtoupper($key));
        }
    }
    // Checks if method is POST
    function checkPOST() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->response("POST_REQUIRED");
        }
    }
    // Checks if all the required arguments are sent
    function checkPOSTData() {
        foreach (func_get_args() as $parameter) {
            if (!isset($_POST[$parameter])) {
                $this->response("FORM_DATA_MISSING");
            }
        }
    }
    // Check that all required data are not empty
    function checkPOSTDataContents() {
        foreach (func_get_args() as $parameter) {
            if (empty($_POST[$parameter])) {
                $this->response("FORM_DATA_EMPTY");
            }
        }
    }
    // Check if the account exists
    function checkAccountExistence($username) {
        if (!file_exists($this->root . "/data/accounts/$username.json")) {
            $this->response("ACCOUNT_DOES_NOT_EXIST");
        }
    }
    // Check password with the one saved
    function checkPassword($username, $password) {
        $user = file_get_contents($this->root . "/data/accounts/$username.json");
        $userdata = json_decode($user, true);
        // Check if password is correct
        if (!password_verify($password, $userdata['password-hash'])) {
            $this->response("INCORRECT_PASSWORD");
        }
    }

}
