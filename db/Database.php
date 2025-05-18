<?php 

class Database {
    private $dbHost;
    private $dbPort;
    private $dbName;
    private $dbUser;
    private $dbPassword;
    private $dbConnection;

    public function __construct()
    {
        // read database credentials from the environment
        $this->dbHost = 'localhost';
        $this->dbPort = '3306';
        $this->dbName = 'bookmarks_db';
        $this->dbUser = 'root';
        $this->dbPassword = 'Secret';
        if (!$this->dbHost || !$this->dbPort || !$this->dbName || !$this->dbUser || !$this->dbPassword){
            die("Please set database credentials as environment variables");
        }
    }

    public function connect(){
        try {
            $this->dbConnection = new PDO(
                'mysql:host=' . $this->dbHost . ';port=' . $this->dbPort . ';dbname=' . $this ->dbName, $this->dbUser, $this->dbPassword);
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        }
        catch(PDOException $e){
            die("Connection Error ". $e->getMessage());
        }
        return $this->dbConnection;
    }
}
