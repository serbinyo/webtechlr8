<?php
session_start();
Functions::add_guest_statistic();

if (isset($_POST['action']) && $_POST['action'] == 'add_new') {
    $GuestbookValidator = new GuestbookValidation();
    $GuestbookValidator->GuestbookValidateRules();
    if ($GuestbookValidator->ValidateForm()) {
        addNewEntry();
        header("Location: " . $_SERVER["REQUEST_URI"]); // предотвращаем повторную отправку формы методом POST путем перенаправления после манипуляций
    } else {
        $errors = true;
    }
}

function addNewEntry() {
    $fio = htmlspecialchars(trim($_POST['fio']));
    $email = htmlspecialchars(trim($_POST['email']));
    $body = htmlspecialchars(trim($_POST['body']));
    $time = date("Y-m-d H:i:s");
    $message = $time . ';';
    $message .= $fio . ';';
    $message .= $email . ';';
    $message .= $body . "\r\n";

    messageToFile($message);
}

function messageToFile($message) {
    if (is_writable('assets/files/messages.inc')) {
        $a = fopen('assets/files/messages.inc', 'a');
        fwrite($a, $message);
        fclose($a);
    }
}

function mycmp($a, $b) {
    return strcmp($b[0], $a[0]);
}

function drawTable($out) {
    $tbl = '<table  class="table-study">';
    $tbl .= '<tr class="topic"><td>Время сообщения</td><td>ФИО</td><td>Email</td><td>Текст отзыва</td></tr>';
    foreach ($out as $v) {
        $tbl .= '<tr><td>' . join("</td><td>", $v) . "</td></tr>";
    }
    $tbl .= '</table>';
    echo $tbl;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Гостевая книга. Сайт Сербина Александра</title>
        <link rel="stylesheet" type="text/css" href="../../public/assets/css/style.css" />
        <script type="text/javascript" src="../../public/assets/js/main.js"></script>		
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
                Functions::HelloUser();

                if (isset($errors)) {
                    $GuestbookValidator->ShowErrors();
                }
                ?>
                <div class="blog_addcontainer">
                    <h3>Форма добавления сообщения</h3>
                    <form action="guestbook" method="post"  class="form">
                        <input type="hidden" name="action" value="add_new" />
                        <div class="message js-form-message"></div>

                        <div class="form-group">
                            <label class="control-label">ФИО:*</label>
                            <div class="form-element">
                                <input type="text" class="inp" name="fio" id="fio" title='Обязательно к заполнению' />
                            </div>
                            <div class="clr"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Email:*</label>
                            <div class="form-element">
                                <input type="text" name="email" class="inp" id="email" title='Обязательно к заполнению' />
                            </div>
                            <div class="clr"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Текст сообщения:*</label>
                            <div class="form-element">
                                <textarea name="body" id="body" class="inp" rows="5" title="Обязательно к заполнению"></textarea>
                            </div>
                            <div class="clr"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">&nbsp;</label>
                            <div class="form-element">
                                <input type="submit" class="form-btn" value="Опубликовать" />
                                <input type="reset" id="opener" class="form-btn-clear" value="Очистить форму" />
                            </div>
                            <div class="clr"></div>
                        </div>
                    </form>
                </div>


                <?php
                $out = array();
                if (is_file('assets/files/messages.inc')) {
                    foreach (file('assets/files/messages.inc') as $v) {
                        $out[] = explode(';', $v);
                    }
                    if (!empty($out)) {
                        usort($out, 'mycmp');
                        drawTable($out);
                    } else {
                        echo '<h3 style="text-align: center;">Пока нет ни отдной записи в гостевой книге</h3>';
                    }
                } else {
                    echo '<h3 style="text-align: center;">Нет файла с записями</h3>';
                }
                ?>
            </main>
        </div>
        <footer>
            <p>Copyright &copy; 2017 Serbin Alexandr</p>
        </footer>

    </body>
</html>