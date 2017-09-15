<?php
session_start();
Functions::add_guest_statistic();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Мой блог. Сайт Сербина Александра</title>
        <link rel="stylesheet" type="text/css" href="../../public/assets/css/style.css" />
        <script type="text/javascript" src="../../public/assets/js/main.js"></script>
        <script>
            function drawComments(i, comment) {
                for (j = 0; j < comment.length; j++) {
                    document.getElementById('commentsblock' + i).innerHTML += comment[j];
                    document.getElementById('commentsblock' + i).innerHTML += '<hr>';
                }
                
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
                Functions::HelloUser();

                // количество записей, выводимых на странице
                $per_page = 5;
                // получаем номер страницы
                $page = (int) (isset($_GET['page']) ? ($_GET['page'] - 1) : 0);
                // вычисляем первый операнд для LIMIT
                $start = abs($page * $per_page);

                // выполняем запрос и выводим записи
                $query = "SELECT * FROM blog ORDER BY date DESC LIMIT $start, $per_page";

                $index = 1;
                $addCommentsOpt = false;
                $userid = Functions::findUser();
                if (!empty($userid)) {
                    $addCommentsOpt = true;

                    $user = UsersModel::find($userid);
                }

                BaseActiveRecord::check_connection();
                foreach (BaseActiveRecord::$pdo->query($query) as $i => $blog) {

                    if (empty($blog['image'])) {
                        $blog['image'] = '../../public/assets/img/noimage.jpg';
                    }

                    echo '<div class="blog_container">';
                    echo "<div class='blog_title'><h3>" . $blog['title'] . "</h3></div>";
                    echo "<div class='blog_image'><img src='" . $blog['image'] . "'  width='250' alt='" . $blog['image'] . "'/></div>";
                    echo "<div class='blog_body'>" . $blog['body'] . "</div>";
                    echo "<div class='blog_date'>Дата публикации: " . $blog['date'] . "</div>";
                    
                    //находим и выводим комменты
                    echo "<div class='blog_body'>Комментарии:<hr><div id='commentsblock$index'></div>";
                    $cmntqry = "SELECT * FROM comments WHERE blogid = '" . $blog['id'] . "' ORDER BY date DESC";
                    ?>
                    <script>
                        var data = [];
                    </script>  
                    <?php
                    foreach (BaseActiveRecord::$pdo->query($cmntqry) as $с => $comment) {
                        $cmnt = $comment['date'] . ' ' . $comment['author'] . ' написал: ' . $comment['body'];
                        ?>
                        <script>
                            data.push('<?php echo $cmnt; ?>');
                        </script>               
                        <?php
                    }
                    ?>
                    <script>
                        drawComments('<?php echo $index; ?>', data);
                    </script>               
                    <?php
                    //дальше вывод для авторизованных пользователей
                    if ($addCommentsOpt) {
                        echo "<button id='btnaddcmnt$index'>Комментировать</button><br>
                        <div id='cmntblock$index' style='display: none'>
                        <textarea id='comment$index' cols='30' rows='10'></textarea><br>
                        <button id='button$index'>Отправить</button></div>";
                        ?>
                        <script>
                            var button<?php echo $index ?> = document.getElementById('button<?php echo $index ?>'),
                                    btnaddcmnt<?php echo $index ?> = document.getElementById('btnaddcmnt<?php echo $index ?>'),
                                    xmlhttp = new XMLHttpRequest();

                            button<?php echo $index ?>.addEventListener('click', function () {
                                var name<?php echo $index ?> = '<?php echo $user->login ?>',
                                        comment<?php echo $index ?> = document.getElementById('comment<?php echo $index ?>').value.replace(/<[^>]+>/g, ''),
                                        blogid<?php echo $index ?> = <?php echo $blog['id'] ?>;
                                if (name<?php echo $index ?> === '' || comment<?php echo $index ?> === '') {
                                    alert('Заполните все поля!');
                                    return false;
                                } else {
                                    xmlhttp.open('post', 'addcomment', true);
                                    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                    xmlhttp.send("name=" + encodeURIComponent(name<?php echo $index ?>) + "&comment=" + encodeURIComponent(comment<?php echo $index ?>) + "&blogid=" + encodeURIComponent(blogid<?php echo $index ?>));
                                    document.getElementById('comment<?php echo $index ?>').value = '';
                                    //выведем комментарии
                                    xmlhttp.onreadystatechange = function () {
                                        if (xmlhttp.readyState == 4) {
                                            if (xmlhttp.status == 200) {
                                                var data = xmlhttp.responseText;
                                                if (data !== 'empty') {
                                                    data = JSON.parse(data);
                                                    document.getElementById('commentsblock' + <?php echo $index; ?>).innerHTML = '';
                                                    drawComments('<?php echo $index; ?>', data);
                                                    var x = document.getElementById('cmntblock<?php echo $index ?>');
                                                    x.style.display = 'none';
                                                } else {
                                                    alert("empty");
                                                }
                                            }
                                        }
                                    };
                                }
                            });

                            btnaddcmnt<?php echo $index ?>.addEventListener('click', function () {
                                var x = document.getElementById('cmntblock<?php echo $index ?>');
                                x.style.display = 'block';
                            });


                        </script>               
                        <?php
                    }
                    echo '</div></div>';
                    $index++;
                }
                // выводим ссылки на страницы:
                $query = "SELECT count(*) FROM blog";
                $total_rows = BaseActiveRecord::$pdo->query($query)->fetchColumn();

                // Определяем общее количество страниц
                $num_pages = ceil($total_rows / $per_page);

                echo '<p>Страницы: ';
                for ($i = 1; $i <= $num_pages; $i++) {
                    // текущую страницу выводим без ссылки
                    if ($i - 1 == $page) {
                        echo $i . " ";
                    } else {
                        echo '<a href="myblog?page=' . $i . '">' . $i . "</a> ";
                    }
                }
                echo '</p>';
                ?>           
            </main>
        </div>
        <footer>
            <p>Copyright &copy; 2017 Serbin Alexandr</p>
        </footer>

    </body>
</html>