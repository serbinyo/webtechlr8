<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StatisticsModel
 *
 * @author Serba
 */
class StatisticsModel extends BaseActiveRecord {

// список полей таблицы
    public $id;
    public $date;
    public $page;
    public $ip;
    public $host;
    public $browser_name;
// имя связанной с AR таблицы в MySQL
    protected static $table = 'statistics';

    public function insert() {
        $sql = "INSERT INTO " . static::$table . " VALUES (null, :date, :page, :ip, :host, :browser_name)";
        $stmt = self::$pdo->prepare($sql);

        $this->date = date("Y-m-d H:i:s");
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':page', $this->page);
        $stmt->bindParam(':ip', $this->ip);
        $stmt->bindParam(':host', $this->host);
        $stmt->bindParam(':browser_name', $this->browser_name);

        $stmt->execute();
    }

    public function update() {
        
    }

}
