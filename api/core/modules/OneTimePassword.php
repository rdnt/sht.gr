<?php

// Class that handles one time password generation and two-factor authentication
class OneTimePassword {

    // Private datamembers
    private $table;
    private $timer;
    private $pin_length;

    /**
     * Initializes the OneTimePassword object
     *
     * @param int $timer The timeslice size in seconds
     * @param int $pinlength The length of the one time password
     */
    function __construct($timer = 30, $pinlength = 6) {
        $this->table = "ABCDEFGHIJKLMNOPQRSTUVWXYZ234567";
        $this->timer = $timer;
        $this->pin_length = $pinlength;
    }

    /**
     * Generates a new cryptographically random key with the specified size
     *
     * @param int $length the length of the generated key
     * @return string generated secret key
     */
    function newKey($length = 32) {
        $secret = "";
        for ($i=0; $i<$length; $i++) {
            // random_int() is used to get cryptographically secure random
            // integers in the range 0-31 (base32 table indexes)
            $secret .= $this->table[random_int(0, 31)];
            if ($i%4==3) {
                $secret .= " ";
            }
        }
        return $secret;
    }

    /**
     * Converts base32 encoded string to binary format
     *
     * @param string $key The secret key
     * @return string binary representation of the base32 encoded string
     */
    function base322bin($key) {
        $binary = "";
        foreach(str_split($key) as $char) {
            $binary.= sprintf("%05b", strpos($this->table, $char));
        }
        $result = "";
        foreach(str_split($binary, 8) as $char) {
            $result .= chr(bindec($char));
        }
        return($result);
    }

    /**
     * Returns the n-digit code that is valid for the specified timeSlice
     *
     * @param string $secret_key The secret key
     * @param string $timeSlice The timeSlice for which the code will be valid
     * @return integer The n-digit code
     */
    function getCode($secret_key, $timeSlice) {
        // Decode the key from base32 to binary
        $secret_key = $this->base322bin($secret_key);
        // Pack time into binary string
        $time = hex2bin("00000000").pack('N*', $timeSlice);
        // Hash it with users secret key
        $hm = hash_hmac('sha1', $time, $secret_key, true);
        // Use last part of result as index/offset
        $offset = ord(substr($hm, -1)) & 0x0F;
        // Grab 4 bytes of the result
        $hashpart = substr($hm, $offset, 4);
        // Unpack binary value
        $value = unpack('N', $hashpart);
        $value = $value[1];
        // Only keep 32 bits
        $value = $value & 0x7FFFFFFF;
        $modulo = pow(10, $this->pin_length);
        return (string)str_pad($value % $modulo, $this->pin_length, '0', STR_PAD_LEFT);
    }

    /**
     * Verifies that the code entered matches the computed one.
     *
     * @param string $secret_key
     * @param string $code
     * @param int $discrepancy specifies the allowed time drift in 30 second units
     */
    function verifyCode($code, $secret_key, $discrepancy = 1) {
        // Compute current timeslice
        $timeSlice = floor(time() / $this->timer);
        // Compute code for all nearby timeslices based on discrepancy
        for ($i=-$discrepancy; $i<=$discrepancy; $i++) {
            if ($this->getCode($secret_key, $timeSlice + $i) == $code) {
                return true;
            }
        }
    }

    /**
     * Returns the current time slice
     *
     * @return int Timeslice
     */
    function getTimeSlice() {
        return floor(time() / $this->timer);
    }

    /**
     * Returns the remaining seconds till the current code no longer applies
     *
     * @return int seconds
     */
    function getRemainingSeconds() {
        return $this->timer - floor(time() % $this->timer);
    }

}
