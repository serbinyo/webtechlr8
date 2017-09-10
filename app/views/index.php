<?php
Functions::add_guest_statistic();
// создаем новую сессию или восстанавливаем текущую
session_start();

function login_form() {

    echo "<div class='login_form_container'>
                            <a class='reg' href='registration'><button>Регистрация</button></a>
                            <form action='index' method='get'>
                            Логин: <input type='text' name='login'>
                            Пароль: <input type='password' name='passwd'>
                            <input type='submit' name='go' value='Вход'>
                            </form>
                            <div style='clear: both'></div>
                            </div>";
}

function logout_form() {
    echo "<div class='login_form_container'>
                        <form action='index' method='post'>
                        <input type='hidden' name='action' value='logout' >
                        Вход выполнен 
                        <input type='submit' value='Выйти'>
                        </form>
                        </div>";
}

if (isset($_GET['go'])) {

    $_SESSION['login'] = htmlspecialchars(trim($_GET['login']));
    $_SESSION['passwd'] = htmlspecialchars(trim($_GET['passwd']));
    // теперь логин и пароль - глобальные переменные для этой сессии
    if (!Functions::findUser()) {
        $error = true;
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
        <title>Главная страница. Сайт Сербина Александра</title>
        <link rel="stylesheet" type="text/css" href="../../public/assets/css/style.css">
        <script type="text/javascript" src="../../public/assets/js/main.js"></script>
        <script>
            function handlePopupClick() {
                window.open(this.href, 'registration', 'width=980, height=600, top=50, left=50, status=no, location=no, toolbar=no, menubar=no');
                return false;
            }

            window.onload = function () {
                var lnks = document.getElementsByTagName('A')
                for (var i = 0; i < lnks.length; i++)
                    if (/\breg\b/.test(lnks[i].className))
                        lnks[i].onclick = handlePopupClick;
            }
        </script>
    </head>
    <body>
        <div id="wrapper">
            <nav id="navmenu">
                <ul>
                    <li><a href="index">Главная</a></li>
                    <li><a href="about">Обо мне</a></li>
                    <li><a href="interests">Мои интересы</a>
                        <ul style="display:none">
                            <li><a href="interests#hobby">Мое хобби</a></li>
                            <li><a href="interests#books">Мои любимые книги</a></li>
                            <li><a href="interests#music">Моя любимые фильмы</a></li>
                        </ul>
                    </li>
                    <li><a href="study">Учеба</a></li>
                    <li><a href="testpage">Тест ОПиАЯ</a></li>                    
                    <li><a href="photo">Фотоальбом</a></li>
                    <li><a href="contact">Контакт</a></li>
                    <li><a href="myblog">Мой блог</a></li>
                    <li><a href="guestbook">Гостевая книга</a></li>                     
                </ul>
            </nav>
            <header></header>
            <main>
                <div id="current-date"></div>
                <?php
                if (isset($error)) {
                    echo "<div class='blog_alert_container'>
                        Неверный ввод, попробуйте еще раз
                        </div>";
                }
                if (Functions::findUser()) {
                    logout_form();
                } else {
                    login_form();
                }
                ?>

                <section>
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <img src="../../public/assets/img/ava.jpg"  width="350" alt=""/>
                                </td>
                                <td>
                                    <h3>Сербин Александр Александрович</h3>
                                    <p><strong>группа: ИС/б-41-з</strong></p>
                                    <p>Лабораторная работа №8 <strong>&quot;Исследование возможностей асинхронного взаимодействия с сервером. Технология AJAX.&quot;</strong></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>	
            </main>
        </div>	
        <footer>
            <p>Copyright &copy; 2017 Serbin Alexandr</p>
        </footer>
    </body>
</html>