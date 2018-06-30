<?php
// Trait that handles HTTP pushing of certain assets
trait AssetPushing {
    // Pushes the assets
    function pushAssets() {
        $version = $this->getLatestCommit();
        if ($this->assets) {
            foreach ($this->assets as $asset => $type) {
                if (file_exists($this->getRoot() . $asset)) {
                    $string = "Link: <$asset?v=$version>; rel=preload; as=$type";
                    header($string, false);
                }
            }
        }
    }
}
