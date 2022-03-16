<?php
require 'controller/database.php';
class Gebruiker{

    private $id                 = '';
    private $voornaam           = '';
    private $achternaam         = '';
    private $email              = '';
    private $adres              = '';
    private $postcode           = '';
    private $woonplaats         = '';
    private $telefoonnummer     = '';

    protected $db;
    public function __construct(){
        $this->db = new DB_con();
        $this->db = $this->db->ret_obj();
    }

    private function getGebruikerTable(){
        return $table = 'gebruikers';
    }

    public function getPostValues(){
            $post_check_array = array (
                'verzenden' => array('filter' => FILTER_SANITIZE_STRING ),
                'update' => array('filter' => FILTER_SANITIZE_STRING ),
                'delete' => array('filter' => FILTER_SANITIZE_STRING ),
                'voornaam' => array('filter' => FILTER_SANITIZE_STRING ),
                'achternaam' => array('filter' => FILTER_SANITIZE_STRING),
                'email' => array('filter' => FILTER_SANITIZE_STRING),
                'adres' => array('filter' => FILTER_SANITIZE_STRING),
                'postcode' => array('filter' => FILTER_SANITIZE_STRING),
                'woonplaats' => array('filter' => FILTER_SANITIZE_STRING),
                'telefoonnummer' => array('filter' => FILTER_SANITIZE_STRING),
                'id' => array('filter' => FILTER_VALIDATE_INT )
            );
            $inputs = filter_input_array( INPUT_POST, $post_check_array );

            //RTS
            return $inputs;
        }

    public function save($input_array){
        try {
            if (!isset($input_array['voornaam']) OR
            !isset($input_array['achternaam'])OR
            !isset($input_array['email'])OR
            !isset($input_array['adres'])OR
            !isset($input_array['postcode'])OR
            !isset($input_array['woonplaats'])OR
            !isset($input_array['telefoonnummer'])){
                throw new Exception("Verplichte velden zijn niet ingevuld") ;
            }
            if ( (strlen($input_array['voornaam']) < 1) OR
                (strlen($input_array['achternaam']) < 1) OR
                (strlen($input_array['email']) < 1)OR
                (strlen($input_array['adres']) < 1)OR
                (strlen($input_array['postcode']) < 1)OR
                (strlen($input_array['woonplaats']) < 1)OR
                (strlen($input_array['telefoonnummer']) < 1)){
                throw new Exception("Verplichte velden zijn leeg") ;
            }
               
             $voornaam           = $input_array['voornaam'];
             $achternaam         = $input_array['achternaam'];
             $email              = $input_array['email'];
             $adres              = $input_array['adres'];
             $postcode           = $input_array['postcode'];
             $woonplaats         = $input_array['woonplaats'];
             $telefoonnummer     = $input_array['telefoonnummer'];

            $sql = "INSERT INTO `".$this->getGebruikerTable()."` (voornaam, achternaam,email,adres,postcode,woonplaats,telefoonnummer) VALUES 
            ('$voornaam','$achternaam','$email','$adres','$postcode','$woonplaats','$telefoonnummer')";
            if (!($this->db->query($sql))) {
                return FALSE;
            }else{
               return TRUE;
            }
            if ( !empty($this->db->last_error) ){
                $this->last_error = $this->db->last_error;
                return FALSE;
            }
        } catch (Exception $exc) {
            return FALSE;
        }
        return TRUE;
    }

    public function setId($id){
        if ( is_int(intval($id) ) ){
            $this->id = $id;
        }
    }
    public function setVoornaam($voornaam){
        if (is_string($voornaam)){
            $this->voornaam = $voornaam;
        }
    }
    public function setAchternaam($achternaam){
        if (is_string($achternaam)){
            $this->achternaam = $achternaam;
        }
    }
    public function setEmail($email){
        if (is_string($email)){
            $this->email = $email;
        }
    }
    public function setAdres($adres){
        if (is_string($adres)){
            $this->adres = $adres;
        }
    }
    public function setPostcode($postcode){
        if (is_string($postcode)){
            $this->postcode = $postcode;
        }
    }
    public function setWoonplaats($woonplaats){
        if (is_string($woonplaats)){
            $this->woonplaats = $woonplaats;
        }
    }
    public function setTelefoonnummer($telefoonnummer){
        if (is_string($telefoonnummer)){
            $this->telefoonnummer = $telefoonnummer;
        }
    }
    public function getId(){
        return $this->id;
    }
    public function getVoornaam(){
        return $this->voornaam;
    }
    public function getAchternaam(){
        return $this->achternaam;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getAdres(){
        return $this->adres;
    }
    public function getPostcode(){
        return $this->postcode;
    }
    public function getWoonplaats(){
        return $this->woonplaats;
    }
    public function getTelefoonnummer(){
        return $this->telefoonnummer;
    }

    public function getGebruikersList(){

        $return_array = array();

        $query = "SELECT * FROM `".$this->getGebruikerTable()."` ORDER BY id";
        $result = $this->db->query($query);

        foreach ($result as $idx => $array){
            $gebruiker = new Gebruiker();
            $gebruiker->setId($array['id']);
            $gebruiker->setVoornaam($array['voornaam']);
            $gebruiker->setAchternaam($array['achternaam']);
            $gebruiker->setEmail($array['email']);
            $gebruiker->setAdres($array['adres']);
            $gebruiker->setPostcode($array['postcode']);
            $gebruiker->setWoonplaats($array['woonplaats']);
            $gebruiker->setTelefoonnummer($array['telefoonnummer']);

            $return_array[] = $gebruiker;
        }
        return $return_array;
    }

    public function getGebruikersAantal(){

        $query = "SELECT COUNT(*) AS nr FROM `". $this->getGebruikerTable()."`";
        $result = $this->db->query( $query );
        $followingdata = $result->fetch_assoc();

        return $followingdata['nr'];
    }

    public function update($input_array){
        $voornaam           = $input_array['voornaam'];
        $achternaam         = $input_array['achternaam'];
        $email              = $input_array['email'];
        $adres              = $input_array['adres'];
        $postcode           = $input_array['postcode'];
        $woonplaats         = $input_array['woonplaats'];
        $telefoonnummer     = $input_array['telefoonnummer'];
        $id                 = $input_array['id'];
        try {
            if (!isset($voornaam) OR
                !isset($achternaam)OR
                !isset($email)OR
                !isset($adres)OR
                !isset($postcode)OR
                !isset($woonplaats)OR
                !isset($telefoonnummer)){
                throw new Exception("U mist verplichte velden");
            }
            if ( (strlen($voornaam) < 1) OR
                (strlen($achternaam) < 1) OR
                (strlen($email) < 1)OR
                (strlen($adres) < 1)OR
                (strlen($postcode) < 1)OR
                (strlen($woonplaats) < 1)OR
                (strlen($telefoonnummer) < 1)){

                throw new Exception("Verplichte velden zijn leeg") ;
            }


            $this->db->query("UPDATE `".$this->getGebruikerTable()."` SET `voornaam` = '".$voornaam."',
             `achternaam` = '".$achternaam."',`email` = '".$email."',`adres` = '".$adres."',
             `postcode` = '".$postcode."',`woonplaats` = '".$woonplaats."',`telefoonnummer` = '".$telefoonnummer."'
            WHERE `".$this->getGebruikerTable()."`.`id` = ".$id.";");

 
            if ( !empty($conn->last_error) ){
                $this->last_error = $conn->last_error;

                return FALSE;
            }
        } catch (Exception $exc) {

        }
        return TRUE;
    }

    public function handleGetAction( $get_array ){
        $action = '';

        switch($get_array['action']){
            case 'update':

                if ( !is_null($get_array['id']) ){
                    $action = $get_array['action'];
                }
                break;

            case 'delete':

                if ( !is_null($get_array['id']) ){
                    $this->delete($get_array);
                }
                $action = 'delete';
                break;

            default:
                break;
        }
        return $action;
    }

    public function getGetValues(){

        $get_check_array = array (
            'action'    => array('filter' => FILTER_SANITIZE_STRING ),
            'id'        => array('filter' => FILTER_VALIDATE_INT ));

        $inputs = filter_input_array( INPUT_GET, $get_check_array );

        return $inputs;

    }

    public function delete($input_array){
        try {

            if (!isset($input_array['id']) ) throw new Exception(("Missing mandatory fields") );

            $this->db->query("DELETE  FROM `" . $this->getGebruikerTable() . "` WHERE id = ".$input_array['id'].".");

        } catch (Exception $exc) {
            return FALSE;
        }
        return TRUE;
    }

}
?>