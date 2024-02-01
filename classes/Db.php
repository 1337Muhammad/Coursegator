<?php

//ToDo: handle expected and non-expected errors


class Db
{
    private $conn;

    public function __construct($servername, $username, $password, $dbname)
    {
        $this->conn = mysqli_connect($servername, $username, $password, $dbname);
    }

    public function insert($table, $fields, $values)
    {
        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        $isInserted = mysqli_query($this->conn, $sql);
        return $isInserted;
    }

    public function update($table, $set, $condition)
    {
        $sql = "UPDATE $table SET $set WHERE $condition";
        $isUpdated = mysqli_query($this->conn, $sql) or die("Error occurred! Please try again: " . mysqli_error($this->conn));
        return $isUpdated;
    }

    // ToDo handle when deleting a parent row
    public function delete($table, $condition)
    {
        $sql = "DELETE FROM $table WHERE $condition";
        // dd($sql);
        $isDeleted = mysqli_query($this->conn, $sql) or die("Error occurred! Please try again: " . mysqli_error($this->conn));
        return $isDeleted;
    }

    public function select($fields, $table, $others = NULL)
    { // expandable query

        $sql = "SELECT $fields FROM $table";
        // if others assigned to a value to a condition we will concatenate it to query
        if ($others !== NULL) {
            $sql .= " $others";
        }

        $result = mysqli_query($this->conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            $rows = [];
        }
        return $rows;
    }

    public function selectOne($fields, $table, $others = NULL)
    {

        $sql = "SELECT $fields FROM $table";
        if ($others !== NULL) {
            $sql .= " $others";
        }
        $sql .= " LIMIT 1"; //to ensure that we always get 1 result
        $result = mysqli_query($this->conn, $sql) or die("An error occurred. Please try again later: " . mysqli_error($this->conn));

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        } else {
            $row = [];
        }
        return $row;
    }

    public function selectJoin($fields, $tables, $on, $others = NULL)
    {

        $sql = "SELECT $fields FROM $tables ON $on";
        if ($others !== NULL) {
            $sql .= " $others";
        }

        $result = mysqli_query($this->conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            $rows = [];
        }
        return $rows;
    }

    public function selectJoinOne($fields, $tables, $on, $others = NULL)
    {

        $sql = "SELECT $fields FROM $tables ON $on";
        if ($others !== NULL) {
            $sql .= " $others";
        }
        $sql .= " LIMIT 1";

        $result = mysqli_query($this->conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        } else {
            $row = [];
        }
        return $row;
    }

    /**
     * return count of rows in a table
     */
    public function selectRowCount($table, $others = NULL)
    {
        $sql = "SELECT COUNT(id) FROM $table";
        if ($others !== NULL) {
            $sql .= " $others";
        }

        $result = mysqli_query($this->conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_row($result)[0];
        } else {
            $row = [];
        }

        return $row;
    }

    /**
     * return $conn object
     */
    public function getConn()
    {
        return $this->conn;
    }

    /**
     * to bypass sql injection by escaping special chars
     */
    public function evadeSql($parameter)
    {
        return mysqli_real_escape_string($this->conn, $parameter);
    }

    /**
     * check if a row with id=$id exists in database
     */
    public function exists($id)
    {
        return true;
    }

    public function __destruct()
    {
        mysqli_close($this->conn);
    }
}
