<?php

class Functions {

    public static function add_guest_statistic() {
//        $statistic = new StatisticsModel();
//        $statistic->page = $_SERVER["REQUEST_URI"];
//        $statistic->ip = $_SERVER["REMOTE_ADDR"];
//        $statistic->host = $_SERVER["HTTP_HOST"];
//        $statistic->browser_name = $_SERVER["HTTP_USER_AGENT"];
//        $statistic->save();
    }

    public static function findUser() {
        $login = '';
        $passwrd = '';
        if (array_key_exists('login', $_SESSION) && array_key_exists('passwd', $_SESSION)) {
            $login = $_SESSION['login'];
            $passwrd = $_SESSION['passwd'];
        }

        $query = "SELECT id FROM users WHERE login = '$login' AND password = '$passwrd'";
        BaseActiveRecord::check_connection();
        $userId = BaseActiveRecord::$pdo->query($query)->fetchColumn();
        if (!empty($userId)) {
            return $userId;
        } else {
            return false;
        }
    }

    public static function HelloUser() {
        if (self::findUser()) {
            $id = self::findUser();
            $user = UsersModel::find($id);
            echo "<div class='login_form_container'>
                        Пользователь: $user->fio
                        </div>";
        }
    }

}
