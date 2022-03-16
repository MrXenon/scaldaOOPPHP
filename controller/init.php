<?php
class Init{

    protected $db;
    public function __construct(){
        $this->db = new DB_con();
        $this->db = $this->db->ret_obj();
        Init::createTableGebruikers();
    }

    public function createTableGebruikers()
    {
        $users = "gebruikers";

        $sql = "CREATE TABLE IF NOT EXISTS $users (
           id INT(11) NOT NULL AUTO_INCREMENT,
           voornaam VARCHAR(30) NULL UNIQUE,
           achternaam VARCHAR(255) NULL,
           email VARCHAR(255) NOT NULL,
           adres VARCHAR(255) NOT NULL,
           postcode VARCHAR(255) NOT NULL,
           woonplaats VARCHAR(255) NOT NULL,
           telefoonnummer VARCHAR(255) NOT NULL,
           PRIMARY KEY  (id))
           ENGINE = InnoDB DEFAULT CHARSET=latin1;";
        $result = mysqli_query($this->db, $sql);
        return $result;
    }
}
?>