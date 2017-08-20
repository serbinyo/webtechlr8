<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsersModel
 *
 * @author Serba
 */
class UsersModel extends BaseActiveRecord {

// список полей таблицы
    public $id;
    public $fio;
    public $email;
    public $login;
    public $password;
    public $date;
// имя связанной с AR таблицы в MySQL
    protected static $table = 'users';
    
    public function insert() {
        $sql = "INSERT INTO " . static::$table . " VALUES (null, :fio, :email, :login, :password, :date)";
        $stmt = self::$pdo->prepare($sql);

        
        $stmt->bindParam(':fio', $this->fio);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':login', $this->login);
        $stmt->bindParam(':password', $this->password);
        $this->date = date("Y-m-d H:i:s");
        $stmt->bindParam(':date', $this->date);
        
        $stmt->execute();        
    }

    public function update() {
        
    }

}
