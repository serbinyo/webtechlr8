<?php

/**
 * Description of TestpageModel
 * класс представляет собой отображение таблицы из БД;
 * каждый экземпляр класса представляет собой строку в отображаемой таблице;
 * код взаимодействует с отображаемой таблицей исключительно через реализованный класс.
 * @author Serba
 */
class TestpageModel extends BaseActiveRecord {

    public $id;
    public $date;
    public $fio;
    public $groupname;
    public $answers;
    public $results;
    public $mark;
    
    protected static $table = 'testpage';

    public function insert() {
        if (!$this->fio || !$this->groupname) {
            return 0;
        }
        $sql = "INSERT INTO " . static::$table . " VALUES (null, :date, :fio, :groupname, :answer1, :result1, :answer2, :result2, :answer3, :result3, :mark)";

        $stmt = self::$pdo->prepare($sql);

        $this->date = date("Y-m-d H:i:s");
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':fio', $this->fio);
        $stmt->bindParam(':groupname', $this->groupname);
        $stmt->bindParam(':answer1', $this->answers['answer1']);
        $stmt->bindParam(':result1', $this->results['result1']);
        $stmt->bindParam(':answer2', $this->answers['answer2']);
        $stmt->bindParam(':result2', $this->results['result2']);
        $stmt->bindParam(':answer3', $this->answers['answer3']);
        $stmt->bindParam(':result3', $this->results['result3']);
        $stmt->bindParam(':mark', $this->mark);

        $stmt->execute();
    }

    public function update() {
        
    }

}
