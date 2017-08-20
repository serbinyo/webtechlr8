<?php
session_start();

$file = @file(__DIR__ . '/pswd.inc');
if (!empty($file)) {
    foreach ($file as $v) {
        $admins[] = explode(' ', $v);
    }
    if (empty($admins)) {
        $error = true;
    }
}

function login_form() {
    echo "<div class='login_form_container'>
                        <form action='../admin' method='get'>
                        Админ логин: <input type='text' name='admin_login'>
                        Админ пароль: <input type='password' name='admin_passwd'>
                        <input type='submit' name='go' value='Вход'>
                        </form>
                        <div style='clear: both'></div>
                        </div>";
}

function logout_form() {
    echo "<div class='login_form_container'>
                        <form action='admin' method='post'>
                        <input type='hidden' name='action' value='logout' >
                        Администратор: вход выполнен <input type='submit' value='Выйти'>
                        </form>
                        </div>";
}

function findAdmin($admins) {
    $admin_login = '';
    $admin_paswrd = '';
    if (array_key_exists('admin_login', $_SESSION) && array_key_exists('admin_passwd', $_SESSION)) {
        $admin_login = $_SESSION['admin_login'];
        $admin_paswrd = $_SESSION['admin_passwd'];
        foreach ($admins as $a) {
            if (($a[0] == $admin_login) && ($a[1]== $admin_paswrd)) {
                return $admin_login;
            }
        }
    }
}

if (isset($_GET['go'])) {
    $_SESSION['admin_login'] = htmlspecialchars(trim($_GET['admin_login']));
    $_SESSION['admin_passwd'] = htmlspecialchars(trim($_GET['admin_passwd']));
    // теперь логин и пароль - глобальные переменные для этой сессии
    if (!findAdmin($admins)) {
        $login_error = true;
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'logout') {
    // уничтожаем сессию
    session_destroy();
    header("Location: " . $_SERVER["REQUEST_URI"]);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Админка. Сайт Сербина Александра</title>
        <link rel="stylesheet" type="text/css" href="../admin/assets/css/admin_style.css">
    </head>
    <body>
        <?php
        if (!findAdmin($admins)) {
            login_form();
        } else {
            logout_form();
            echo <<<EOT
    <center>
        <iframe src="../adminmenu" width="1200" height="340" name="iframe_menu" >
            Ваш браузер не поддерживает встроенные фреймы!
        </iframe>
        <iframe src="../content" width="1200" height="1060" name="iframe_a" >
            Ваш браузер не поддерживает встроенные фреймы!
        </iframe>
    </center>
EOT;
        }

        if (isset($error)) {
            echo "<div class='blog_alert_container'>
                Файл учетных записей администраторов: ошибка открытия или чтения.<br>
                Доступ закрыт.<br>
                Обратитесь к системному администратору
                </div>";
        } elseif (isset($login_error)) {
            echo "<div class='blog_alert_container'>
                Ошибка ввода. Учетная запись администратора не найдена.<br>
                </div>";
        }
        ?>
    </body>
</html>