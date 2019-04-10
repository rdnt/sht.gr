<?php

// Trait that handles HTTP2 pushing of certain assets
trait AssetPushing {

    /**
     * Pushes the assets as headers in HTTPv2 responses
     */
    function pushAssets() {
        // Get version from git module
        $version = $this->version;
        // Initialize push required flag
        $flag = false;
        // Version cookie doesn't exist, probably first timer, or cleared cookies
        // and maybe cache, so let's push the assets
        if (!isset($_COOKIE['version'])) {
            // Cookie expires in 1 week
            setcookie('version', $version, time()+(7*24*60*60), '/', '');
            $flag = true;
        }
        else if ($_COOKIE['version'] != $version) {
            // Version is different, so assets need to be refreshed, push them in advance
            setcookie('version', $version, time()+(7*24*60*60), '/', '');
            $flag = true;
        }
        // If assets are set and they should be pushed, push them
        if ($this->assets && $flag) {
            foreach ($this->assets as $asset => $type) {
                if (file_exists($this->getRoot() . $asset)) {
                    $string = "Link: <$asset?v=$version>; rel=preload; as=$type";
                    // Send the appropriately formatted headers
                    header($string, false);
                }
            }
        }
    }

}
