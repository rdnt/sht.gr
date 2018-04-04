<?php
// Trait that handles login
trait Login {
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
