<?php
// Trait that handles login
trait Login {
    // Check if the account exists
    function checkAccountExistence($username) {
        if (!file_exists($this->getRoot() . "/data/accounts/$username.json")) {
            $this->response("ACCOUNT_DOES_NOT_EXIST");
        }
    }
    // Check password with the one saved
    function checkPassword($username, $password) {
        $user = file_get_contents($this->getRoot() . "/data/accounts/$username.json");
        $userdata = json_decode($user, true);
        // Check if password is correct
        if (!password_verify($password, $userdata['password-hash'])) {
            $this->response("INCORRECT_PASSWORD");
        }
    }
    // Returns an json array containing all userdata
    function getUserdata($username) {
        $user = file_get_contents($this->getRoot() . "/data/accounts/$username.json");
        return json_decode($user, true);
    }
    // Saves json data for the specific user
    function saveUserdata($username, $data) {
        file_put_contents($this->getRoot() . "/data/accounts/$username.json", json_encode($data, JSON_PRETTY_PRINT));
    }
    // Compares password and repeat_password
    function comparePasswords($password, $repeat_password) {
        if ($password !== $repeat_password) {
            $this->response("PASSWORDS_DO_NOT_MATCH");
        }
    }
    // Checks if the user is logged in
    function checkLogin() {
        if (!isset($_SESSION['login'])) {
            $this->response("NOT_LOGGED_IN");
        }
    }
    // Checks if a user is logged out
    function checkLogout() {
        if (isset($_SESSION['login'])) {
            $this->response("ALREADY_LOGGED_IN");
        }
    }
    // Logs the user out
    function logout() {
        if (isset($_SESSION['login'])) {
            unset($_SESSION['login']);
            $this->response("SUCCESS");
        }
        else {
            $this->response("NOT_LOGGED_IN");
        }
    }
}
