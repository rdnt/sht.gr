<?php

// Trait that handles HTTP2 pushing of certain assets
trait AssetPushing {

    /**
     * Pushes the assets as headers in HTTPv2 responses
     */
    function pushAssets() {
        // Get version from github module and append it to refresh cache
        $version = $this->getLatestCommit();
        if ($this->assets) {
            // If assets are set push each of them
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
