<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Загрузка сообщений гостевой книги. Сайт Сербина Александра</title>
        <link rel="stylesheet" type="text/css" href="../admin/assets/css/admin_style.css">
        <script type="text/javascript" src="../../public/assets/js/main.js"></script>		
    </head>
    <body>
        <div id="wrapper">

            <main>

                <div id="current-date"></div>

                <h2> Форма для загрузки файлов </h2>

                <form action="guestbookloadfile" class="form-fileload" method="post" enctype="multipart/form-data">
                    <input type="file" name="messages"/> <br>
                    <input type="submit" value="3arpyзить" name="loadfile"/>
                </form>

                <?php
                if (isset($_POST['loadfile'])) {
                    $source = $_FILES["messages"]["tmp_name"];
                    $dest = WWW . '/assets/files/' . $_FILES["messages"]["name"];
                    if (is_file($source)) {
                        if ($_FILES["messages"]["name"] === 'messages.inc') {
                            if (copy($source, $dest)) {
                                echo('<h3 style="text-align: center; color: blue;">Файл успешно загружен</h3>');
                            } else {
                                echo('<h3 style="text-align: center; color: red;">Ошибка загрузки файла</h3>');
                            }
                        } else {
                            echo '<h3 style="text-align: center; color: red;">Ошибка. Требуется messages.inc</h3>';
                        }
                    } else {
                        echo('<h3 style="text-align: center; color: red;">Ошибка чтения файла</h3>');
                    }
                }
                ?>

            </main>
        </div>
        <footer>
            <p>Copyright &copy; 2017 Serbin Alexandr</p>
        </footer>

    </body>
</html>