<?php
session_start();
Functions::add_guest_statistic();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Мои интересы. Сайт Сербина Александра</title>
        <link rel="stylesheet" type="text/css" href="../../public/assets/css/style.css" />
        <script type="text/javascript" src="../../public/assets/js/main.js"></script>		
    </head>
    <body>

        <?php

        function print_ul_li() {
            $numargs = func_num_args();
            echo '<ul>';
            $arg_list = func_get_args();
            for ($i = 0; $i < $numargs; $i++) {
                echo '<li>' . $arg_list[$i] . '</li>';
            }
            echo '</ul>';
        }
        ?>

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
                ?>
                <div id="hobby-nav">
                    <a href="#hobby">мое хобби</a> | 
                    <a href="#books">мои любимые книги</a> | 
                    <a href="#music">мои любимые фильмы</a>
                </div>

                <section> 

                    <h3 id="hobby">Мое хобби</h3>

                    <?php
                    print_ul_li(
                            'Футбол', 'КВН'
                    );
                    ?>

                    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

                    <h3 id="books">Мои любимые книги</h3>

                    <?php
                    print_ul_li(
                            '&quot;Братья Карамазовы&quot; Федор Михайлович Достоевский', '&quot;Три товарища&quot; Эрих Мария Ремарк'
                    );
                    ?>

                    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

                    <h3 id="music">Мои любимые фильмы</h3>

                    <?php
                    print_ul_li(
                            'Криминальное чтиво', 'Кровавый четверг', 'На игле'
                    );
                    ?>

                    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                </section>

            </main>
        </div>	
        <footer>
            <p>Copyright &copy; 2017 Serbin Alexandr</p>
        </footer>

    </body>
</html>