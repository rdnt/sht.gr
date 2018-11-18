<?php
// Trait that handles database schema updating
trait Schema {
    function getHashFromDB() {
        return $this->db->query("
            SELECT value
            FROM options
            WHERE option = 'hash';
        ");
    }

    function CheckForSchemaUpdate($branch) {
        $db_hash = $this->getHashFromDB();
        $commit_hash = $this->getLatestCommit($branch);
        if ($db_hash != $commit_hash) {
            return true;
        }
        return false;
    }

    function updateDB($branch = "master") {
        if ($this->CheckForSchemaUpdate($branch)) {
            $db = $this->shell;
            $sql = file_get_contents($this->getRoot() . "/schema.sql");

            $this->db->recreateDB($db);
            $this->db->multi_query("
                $sql
            ");
            $commit_hash = $this->getLatestCommit($branch);
            $this->db->query("
                UPDATE options
                SET options.value = '$commit_hash'
                WHERE options.option = 'hash';
            ");
        }
    }
}
