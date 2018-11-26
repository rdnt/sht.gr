<?php

// Trait that handles endpoint operations
trait FormHandling {

    /**
     * Echoes an appropriately formatted response and stops script execution
     *
     * @param string $response The response string to return
     * @param string $json The json array to append to the response
     */
    function response($response, $json = null) {
        // Initialize json array and echo it
        $json_array = array(
            "response" => $response,
            "data"     => $json
        );
        echo json_encode($json_array);
        // Stop script execution
        die();
    }

    /**
     * Checks if a value matches the regular expression of the giveen property
     *
     * @param string $key The datatype to validate
     * @param string $value The value that was submitted
     */
    function validatePattern($key, $value) {
        if (!array_key_exists($key, $this->patterns)) {
            return false;
        }
        if (!preg_match($this->getPattern($key), $value)) {
            return false;
        }
        return true;
    }

    /**
     * Checks if the request method is POST
     */
    function checkPOST() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            // Send error response if it's not
            $this->response("POST_REQUIRED");
        }
    }

    /**
     * Checks if all the required arguments are sent
     *
     * @param string $data The sent POST keys
     */
    function checkPOSTData() {
        $response_data = array();
        foreach (func_get_args() as $parameters) {
            if (is_array($parameters)) {
                foreach ($parameters as $outer_parameter => $data) {
                    if (is_array($data)) {
                        foreach ($data as $inner_parameter) {
                            if (!isset($_POST[$outer_parameter][$inner_parameter])) {
                                $this->response("FORM_DATA_MISSING");
                            }
                        }
                    }
                    else if ($data) {
                        if (!isset($_POST[$outer_parameter])) {
                            $this->response("FORM_DATA_MISSING");
                        }
                        $value = $_POST[$outer_parameter];
                        if ($data) {
                            $regex = substr($data, strlen("validate:"));
                            $valid = $this->validatePattern($regex, $value);
                        }
                        else {
                            $valid = true;
                        }
                        if (!$valid) {
                            $response_data[] = $outer_parameter;
                        }
                    }
                }
            }
            else {
                foreach (func_get_args() as $parameter) {
                    if (!isset($_POST[$parameter])) {
                        $this->response("FORM_DATA_MISSING");
                    }
                }
            }
        }
        if (!empty($response_data)) {
            $this->response("INVALID_DATA", $response_data);
        }
    }

    function escapeString($string) {
        return htmlspecialchars($string);
    }

    function applyConstraints($variable, $constraint) {
        if (!eval("return $constraint;")) {
            return false;
        }
        return true;
    }

    /**
     * Verifies POST data by combining the required checks
     *
     * @param string $data The sent POST keys
     */
    function verifyPOSTData() {
        $this->checkPOST();
        // Call the checkPOSTData functions with the input keys
        call_user_func_array(array($this, 'checkPOSTData'), func_get_args());
    }

}
