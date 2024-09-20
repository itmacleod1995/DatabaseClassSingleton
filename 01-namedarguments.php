<?php

/**
 * Singleton Database connect class w/static variables and magic methods
 */
class DatabaseConnect {
    public static $pdo;

    public array $attributes;

    private function __construct(){
        echo "Only one instantiation" . "<br>";

        $this->attributes = [
            'server_name' => 'localhost',
            'dbname' => 'note_app',
            'username' => 'root',
            'password' => ''
        ];


        try {
            //self::$pdo = new PDO("mysql:host=localhost;dbname=note_app", 'root', '');
            self::$pdo = new PDO("mysql:host={$this->attributes['server_name']};dbname={$this->attributes['dbname']}", $this->attributes['username'], $this->attributes['password']);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        
    }

    public static function createConnection(){
        if(!isset(self::$pdo)){
            self::$pdo = new DatabaseConnect();
        }

        return self::$pdo;
    }

    /**Magic Methods */

    public function __get($key){
        if(isset($this->attributes[$key])){
            return $this->attributes[$key];
        }
    }

    public function __set($key, $value){
        $this->attributes[$key] = $value;
    }

}

//creating two instances of the singleton
$pdo = DatabaseConnect::createConnection();
$pdo2 = DatabaseConnect::createConnection();

//Checking that both instances are the same
var_dump($pdo == $pdo2);

echo "<br>";

//Use __get magic method, which should return 'root'
var_dump($pdo->username);

echo "<br>";

//Use __set magic method which will set username to 'new_username'
$pdo->username = 'new_username';

var_dump($pdo);

echo "Done"; 







