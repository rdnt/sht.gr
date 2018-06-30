<?php
// Trait that handles endpoint operations
trait FormHandling {
    // Echoes a response and kills the running script
    function response($response, $json = null) {
        $json_array = array(
            "response" => $response,
            "data"     => $json
        );
        echo json_encode($json_array);
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
    // Verifies POST data by combining the required checks
    function verifyPOSTData() {
        $this->checkPOST();
        call_user_func_array(array($this, 'checkPOSTData'), func_get_args());
        call_user_func_array(array($this, 'checkPOSTDataContents'), func_get_args());
    }
}
