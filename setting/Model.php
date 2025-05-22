<?php
require_once("../common/database.php");

class Model {
    protected $db;
    protected $table;

    public function __construct()
    {
        global $mysqli;
        $this->db = $mysqli;
        $this->table = strtolower(get_class($this));
    }

    protected function escape($value)
    {
        return mysqli_real_escape_string($this->db, $value);
    }

    public function save()
    {
        $props = get_object_vars($this);
        unset($props['db'], $props['table']);

        $columns = [];
        $values = [];

        foreach ($props as $key => $val) {
            if ($key === 'id') continue;
            $columns[] = "`$key`";
            $values[] = "'" . $this->escape($val) . "'";
        }

        $sql = "INSERT INTO `{$this->table}` (" . implode(',', $columns) . ")
                VALUES (" . implode(',', $values) . ")";

        return mysqli_query($this->db, $sql);
    }

    public function update($id)
    {
        $props = get_object_vars($this);
        unset($props['db'], $props['table']);

        $set = [];

        foreach ($props as $key => $val) {
            if ($key === 'id') continue;
            $set[] = "`$key` = '" . $this->escape($val) . "'";
        }

        $sql = "UPDATE `{$this->table}` SET " . implode(',', $set) . " WHERE id = '{$this->escape($id)}'";
        return mysqli_query($this->db, $sql);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM `{$this->table}` WHERE id = '{$this->escape($id)}'";
        return mysqli_query($this->db, $sql);
    }
    public function search($term)
    {
        $term = $this->escape($term);
        $columns = [];
        $result = mysqli_query($this->db, "SHOW COLUMNS FROM `{$this->table}`");
        while ($row = mysqli_fetch_assoc($result)) {
            $columns[] = "`{$row['Field']}` LIKE '%$term%'";
        }

        if (empty($columns)) return [];

        $sql = "SELECT * FROM `{$this->table}` WHERE " . implode(' OR ', $columns);
        $result = mysqli_query($this->db, $sql);

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

}
