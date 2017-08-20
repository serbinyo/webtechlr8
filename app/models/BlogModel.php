<?php

/**
 * Description of BlogModel
 * класс представляет собой отображение таблицы из БД;
 * каждый экземпляр класса представляет собой строку в отображаемой таблице;
 * код взаимодействует с отображаемой таблицей исключительно через реализованный класс.
 * @author Алксандерус
 */
class BlogModel extends BaseActiveRecord {

// список полей таблицы
    public $id;
    public $title;
    public $image;
    public $body;
    public $date;
// имя связанной с AR таблицы в MySQL
    protected static $table = 'blog';

    public function insert() {
        if (!$this->title || !$this->body) {
            return 0;
        }
        $sql = "INSERT INTO " . static::$table . " VALUES (null, :title, :image, :body, :date)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':body', $this->body);
        if (empty($this->date)) {
            $this->date = date("Y-m-d H:i:s");
            $stmt->bindParam(':date', $this->date);
        } else {
            $stmt->bindParam(':date', $this->date);
        }

        $stmt->execute();
    }

    public function update() {
        $sql = "UPDATE " . static::$table . " SET title = :title, image = :image, body = :body, date = :date WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':body', $this->body);
        if (empty($this->date)) {
            $this->date = date("Y-m-d H:i:s");
            $stmt->bindParam(':date', $this->date);
        } else {
            $stmt->bindParam(':date', $this->date);
        }
        $stmt->execute();
    }

}
