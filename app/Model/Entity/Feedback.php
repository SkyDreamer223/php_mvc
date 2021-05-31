<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Feedback {
    
    /**
     * Id de la message
     *
     * @var integer
     */
    public $id;

    /**
     * Aucteur de la meesage
     *
     * @var string
     */
    public $nom;

    /**
     * Contenu de la message
     *
     * @var string
     */
    public $message;

    /**
     * date
     *
     * @var string
     */
    public $date;

    /**
     * Nombre de messages dans la base
     *
     * @var integer
     */
    public $qtd;
 
    /**
     * Inserer sur la base
     *
     * @return boolean
     */
    public function insert(){

        $this->date = date('Y-m-d H:i:s');

        $this->id = (new Database('feedback'))->insert([
            'nom'       => $this->nom,
            'message'   => $this->message,
            'date'      => $this->date
        ]);
        
        return true;
    }

    /**
     * Methode qui retourne les messages de la base
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $field
     * @return PDOStatement
     */     
    public static function getFeedbacks($where = null, $order = null, $limit = null, $fields = '*'){

        return (new Database('feedback'))->select($where, $order, $limit, $fields);
    }
}