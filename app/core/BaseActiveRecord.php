<?php

/**
 * Description of BaseActiveRecord
 * @author Serba
 */
abstract class BaseActiveRecord {

// объект для доступа к PDO
    public static $pdo;
    protected static $table;

    protected static function do_connect() {
        $db = require ROOT . '/config/config_db.php';
        try {
            self::$pdo = new \PDO(
                    $db['dsn'], $db['user'], $db['pass'], [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
        } catch (PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }
    }

    public static function check_connection() {
        if (empty(self::$pdo)) {
            self::do_connect();
        }
    }

// интерфейс AR паттерна

    public static function find($id) {
        self::check_connection();
        // подготавливаем SQL запрос
        $query = 'SELECT * FROM ' . static::$table . ' WHERE id = :id';
        $s = self::$pdo->prepare($query);
        // подставляем в запрос идентификатор записи,
        // которую необходимо извлечь из БД
        $s->bindParam(':id', $id);
        // получаем запись из БД в виде ассоциативного массива
        $s->execute();
        $row = $s->fetch(PDO::FETCH_ASSOC);
        // если ничего не найдено, то возвращаем NULL
        if (!$row) {
            return null;
        }
        // создаем текущий AR объект и возвращаем его в качестве результата
        $ar = new static();
        foreach ($row as $key => $value) {
            $ar->$key = $value;
        }
        return $ar;
    }

    public static function findAll() {
        self::check_connection();
        $sql = 'SELECT * FROM ' . static::$table;
        $s = self::$pdo->query($sql);
        $rows = $s->fetchAll(PDO::FETCH_ASSOC);
        if (!$rows) {
            return null;
        }
        // создаем текущий AR объект и записываем его в массив результатов
        foreach ($rows as $row) {
            $ar = new static();
            foreach ($row as $key => $value) {
                $ar->$key = $value;
            }
            $ars[] = $ar;
        }
        return $ars;
    }

    public static function count() {
        self::check_connection();
        $sql = "SELECT COUNT(`id`) as `countID` FROM " . static::$table;
        $s = self::$pdo->query($sql);
        $row = $s->fetch(PDO::FETCH_ASSOC);
        $count = (int) $row['countID'];
        //return $row;
        return $count;
    }

    public function save() {
        self::check_connection();
        if (isset($this->id)) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    public function delete() {
        self::check_connection();
        if (isset($this->id)) {
            $sql = "DELETE FROM " . static::$table . " WHERE id = :id";
//            echo "<p>DELETE:</p>" . $sql . ' ' . $this->id;
            $stmt = self::$pdo->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        } else {
            echo '<p>Id не найден</p>';
        }
    }

    abstract function insert();

    abstract function update();
}
