<?php
define('DB_HOST', "localhost");
define('DB_NAME', "productsDB");
define('DB_USER', "scandi");
define('DB_PASS', "UZ@lpU2u6V@6UaKN");
class Database
{
    public function __construct()
    {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
            $this->connection = new PDO($dsn, DB_USER, DB_PASS);
            return  $this->connection;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    //read from database
    public function read($query, $data = array())
    {
        $statement = $this->connection->prepare($query);
        $result = $statement->execute($data);

        if ($result) {
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (is_array($data)) {
                return $data;
            }
        }
        return false;
    }
    //write to database
    public function write($query, $data = array())
    {
        $statement = $this->connection->prepare($query);
        $result = $statement->execute();

        if ($result) {
            return $this->connection->lastInsertId();
        }
        return false;
    }
}