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
        if (!preg_match($this->getPattern($key), $value)) {
            // Send the correct error response
            $this->response("INVALID_" . strtoupper($key));
        }
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
                    else {
                        if (!isset($_POST[$data])) {
                            $this->response("FORM_DATA_MISSING");
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
    }

    /**
     * Verify that none of the required data are empty
     *
     * @param string $data The sent POST keys
     */
    function checkPOSTDataContents() {
        foreach (func_get_args() as $parameters) {
            if (is_array($parameters)) {
                foreach ($parameters as $outer_parameter => $data) {
                    if (is_array($data)) {
                        foreach ($data as $inner_parameter) {
                            if (empty($_POST[$outer_parameter][$inner_parameter])) {
                                $this->response("FORM_DATA_EMPTY");
                            }
                        }
                    }
                    else {
                        if (empty($_POST[$data])) {
                            $this->response("FORM_DATA_EMPTY");
                        }
                    }
                }
            }
            else {
                foreach (func_get_args() as $parameter) {
                    if (empty($_POST[$parameter])) {
                        $this->response("FORM_DATA_EMPTY");
                    }
                }
            }
        }
    }

    /**
     * Verifies POST data by combining the required checks
     *
     * @param string $data The sent POST keys
     */
    function verifyPOSTData() {
        $this->checkPOST();
        // Call the checkPOSTData(contents) functions with the input keys
        call_user_func_array(array($this, 'checkPOSTData'), func_get_args());
        //call_user_func_array(array($this, 'checkPOSTDataContents'), func_get_args());
    }

}
