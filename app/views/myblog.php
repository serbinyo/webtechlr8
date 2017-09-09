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
                    echo '</div>';
                    //дальше вывод для авторизованных пользователей
                    if (Functions::findUser()) {
                        echo '<span>Имя: </span><br>
                        <input type="text" id="name"><br>
                        <span>Комментарий</span><br>
                        <textarea id="comment" cols="30" rows="10"></textarea><br>
                        <button id="button">Отправить</button>';
                        ?>
                        <script>
                            var button = document.getElementById('button'),
                                    xmlhttp = new XMLHttpRequest();
                            button.addEventListener('click', function () {
                                var name = document.getElementById('name').value.replace(/<[^>]+>/g, ''),
                                        comment = document.getElementById('comment').value.replace(/<[^>]+>/g, '');
                                if (name === '' || comment === '') {
                                    alert('Заполните все поля!');
                                    return false;
                                }
                                xmlhttp.open('post', 'addcomment', true);
                                xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                xmlhttp.send("name=" + encodeURIComponent(name) + "&comment=" + encodeURIComponent(comment));
                                document.getElementById('name').value='';
                                document.getElementById('comment').value='';
                            });
                        </script>
                        <?php
                    }
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