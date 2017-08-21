<?php

if (empty($_POST['name'])) {
    echo 'Empty';
} else {
    sleep(1);
    checkUniqueLogin();
}

function checkUniqueLogin() {
    $login = htmlspecialchars(trim($_POST['name']));
    $query = "SELECT count(*) FROM users WHERE login = '$login'";
    BaseActiveRecord::check_connection();
    $total_rows = BaseActiveRecord::$pdo->query($query)->fetchColumn();
    if ($total_rows === '0') {
        echo 'Success';
    } else {
        echo 'Fail';
    }
}
