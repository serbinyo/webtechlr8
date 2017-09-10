<?php


/**
 * Description of CommentsModel
 *
 * @author Serba
 */
class CommentsModel extends BaseActiveRecord {

// список полей таблицы
    public $id;
    public $blogid;
    public $author;
    public $body;
    public $date;
// имя связанной с AR таблицы в MySQL
    protected static $table = 'comments';

    public function insert() {
        if (!$this->author || !$this->body) {
            return 0;
        }
        $sql = "INSERT INTO " . static::$table . " VALUES (null, :blogid, :author, :body, :date)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':blogid', $this->blogid);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':body', $this->body);
        $this->date = date("Y-m-d H:i:s");
        $stmt->bindParam(':date', $this->date);

        $stmt->execute();
    }

    public function update() {
        $sql = "UPDATE " . static::$table . " SET title = :author, body = :body, date = :date WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':blogid', $this->blogid);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':body', $this->body);
        $this->date = date("Y-m-d H:i:s");
        $stmt->bindParam(':date', $this->date);

        $stmt->execute();
    }

}
