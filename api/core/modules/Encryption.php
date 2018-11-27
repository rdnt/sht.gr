<?php

// Trait that handles content encryption
trait Encryption {

    /**
     * Encrypts a message using AES-256-GCM and the given key
     *
     * @param string $message The message to be encrypted
     * @param string $key The secret key, should be 256 bits long (32 bytes)
     * @return string The cipherblock, which contains the ciphertext, iv and
     *                tag, separated by a dot (.)
     */
    function encrypt($message, $key) {
        // Verify openssl extention is loaded
        if (!extension_loaded ("openssl")) {
            return;
        }
        // AES with the Galois/Counter mode is used, which is a block cipher
        // that offers better performance and parallelism, and by using a 256
        // bits long key, enterprise-level encryption can be achieved.
        $cipher = "aes-256-gcm";
        // The initialization vector should be 16 bytes (128 bits) long,
        // and should be unique and random.
        $iv = openssl_random_pseudo_bytes(16);
        // Perform the encryption and get the ciphertext
        $ciphertext = openssl_encrypt($message, $cipher, $key, 0, $iv, $tag);
        // Create the cipherblock array, containing the ciphertext, the iv and
        // the integrity tag
        $cipherblock = [
            bin2hex($ciphertext),
            bin2hex($iv),
            bin2hex($tag)
        ];
        // Return the formatted cipherblock
        return implode (".", $cipherblock);
    }

    /**
     * Decrypts a message using the given key, IV and the integrity tag
     *
     * @param string $key The decryption key
     * @param string $cipherblock Dot-separated string containing the,
     *               ciphertext, iv and authentication tag.
     * @return string|bool Original message or false if the decryption failed
     */
    function decrypt($key, $cipherblock) {
        // The same cipher is used, duh
        $cipher = "aes-256-gcm";
        // Recreate the cipherblock array from the cipherblock string
        $cipherblock = explode(".", $cipherblock);
        // Convert hexadecimal values to binary
        $ciphertext = hex2bin($cipherblock[0]);
        $iv = hex2bin($cipherblock[1]);
        $tag = hex2bin($cipherblock[2]);
        // Perform the decryption and return the decrypted message
        // If decryption or authentication fails, false is returned
        return openssl_decrypt($ciphertext, $cipher, $key, 0, $iv, $tag);
    }

}
