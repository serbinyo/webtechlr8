<?php
session_start();
Functions::add_guest_statistic();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Фотоальбом. Сайт Сербина Александра</title>
        <link rel="stylesheet" type="text/css" href="../../public/assets/css/style.css" />
        <link rel="stylesheet" type="text/css" href="../../public/assets/css/photoalbum.css" />
        <script type="text/javascript" src="../../public/assets/js/main.js"></script> 
        <!--<script type="text/javascript" src="@(Url.Content("../../public/assets/js/main.js"))"></script> -->
        <script type="text/javascript" src="../../public/assets/js/jquery-1.4.3.min.js"></script>
        <script type="text/javascript" src="../../public/assets/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
        <script type="text/javascript" src="../../public/assets/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <link rel="stylesheet" type="text/css" href="../../public/assets/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

        <script type="text/javascript">
            $(document).ready(function () {
                $("a.stad_photo").fancybox({
                    transitionIn: 'elastic',
                    transitionOut: 'elastic',
                    speedIn: 300,
                    speedOut: 300,
                    hideOnOverlayClick: false
                });
            });
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

                $fotos = array();
                $fotos[0] = "../../public/assets/img/stadiums/s1.jpg";
                $fotos[1] = "../../public/assets/img/stadiums/s2.jpg";
                $fotos[2] = "../../public/assets/img/stadiums/s3.jpg";
                $fotos[3] = "../../public/assets/img/stadiums/s4.jpg";
                $fotos[4] = "../../public/assets/img/stadiums/s5.jpg";
                $fotos[5] = "../../public/assets/img/stadiums/s6.jpg";
                $fotos[6] = "../../public/assets/img/stadiums/s7.jpg";
                $fotos[7] = "../../public/assets/img/stadiums/s8.jpg";
                $fotos[8] = "../../public/assets/img/stadiums/s9.jpg";
                $fotos[9] = "../../public/assets/img/stadiums/s10.jpg";
                $fotos[10] = "../../public/assets/img/stadiums/s11.jpg";
                $fotos[11] = "../../public/assets/img/stadiums/s12.jpg";
                $fotos[12] = "../../public/assets/img/stadiums/s13.jpg";
                $fotos[13] = "../../public/assets/img/stadiums/s14.jpg";
                $fotos[14] = "../../public/assets/img/stadiums/s15.jpg";

                $titles = array();
                $titles[0] = "<p>Сантьяго Бернабеу <br/>Мадрид, Испания <br/>Вместимость 85 454</p>";
                $titles[1] = "<p>Олд Траффорд <br/>Манчестер, Англия <br/>Вместимость 75 731</p>";
                $titles[2] = "<p>Камп Ноу <br/>Барселона <br/>Вместимость 99 786</p>";
                $titles[3] = "<p>Хуан Доминго Перон <br/>Авельянеда, Аргентина <br/>Вместимость	51 389 </p>";
                $titles[4] = "<p>Арена Гремио <br/>Порту-Алегри, Бразилия <br/>Вместимость 60 540</p>";
                $titles[5] = "<p>Монументаль У <br/>Лима, Перу <br/>Вместимость 80 093</p>";
                $titles[6] = "<p>Мультива <br/>Пуэбла-де-Сарагоса, Мексика <br/>Вместимость 51 726</p>";
                $titles[7] = "<p>Альянц Арена <br/>Мюнхен, Германия <br/>Вместимость 71 137</p>";
                $titles[8] = "<p>Олимпийский стадион<br/>Рим, Италия <br/>Вместимость 73 261</p>";
                $titles[9] = "<p>Тюрк Телеком Арена <br/>Стамбул, Турция  <br/>Вместимость 52 650</p>";
                $titles[10] = "<p>Муниципал де Авейру <br/>Авейру, Португалия <br/>Вместимость	30 127</p>";
                $titles[11] = "<p>Ацтека <br/>Мехико, Мексика <br/>Вместимость 105 064</p>";
                $titles[12] = "<p>Олимпийский стадион <br/>Баку, Азербайджан <br/>Вместимость 68 195</p>";
                $titles[13] = "<p>Маракана <br/>Рио-де-Жанейро, Бразилия <br/>Вместимость 78 838</p>";
                $titles[14] = "<p>Стадион ФК Краснодар <br/>Краснодар, Россия <br/>Вместимость 34 291</p>";

                $team = array();
                $team[0] = "ФК «Реал Мадрид»";
                $team[1] = "ФК «Манчестер Юнайтед»";
                $team[2] = "ФК «Барселона»";
                $team[3] = "ФК «Расинг»";
                $team[4] = "ФК «Гремио»";
                $team[5] = "ФК «Университарио»";
                $team[6] = "ФК «Пуэбла»";
                $team[7] = "ФК «Бавария Мюнхен» и ФК «Мюнхен 1860»";
                $team[8] = "ФК «Лацио» и ФК «Рома»";
                $team[9] = "ФК «Галатасарай»";
                $team[10] = "ФК «Бейра-Мар»";
                $team[11] = "сборная Мексики и ФК «Америка»";
                $team[12] = "сборная Азербайджана";
                $team[13] = "сборная Бразилии, ФК «Фламенго» и ФК «Флуминенсе»";
                $team[14] = "ФК «Краснодар»";

                echo '<table class="table-photo">';
                $photos_per_row = 5;
                $rows_count = ceil(count($fotos) / $photos_per_row);
                $idx = 0;

                for ($i = 0; $i < $rows_count; $i++) {
                    echo '<tr>';
                    for ($j = 0; $j < $photos_per_row; $j++) {
                        echo '<td>';
                        if (isset($fotos[$idx])) {
                            $curr_title = isset($titles[$idx]) ? $titles[$idx] : '<p>Нет информации</br></br></br></p>';
                            $curr_team = isset($team[$idx]) ? $team[$idx] : 'Нет информации о домашней команде';

                            echo '<a rel="gallery" class="stad_photo" href="' . $fotos[$idx] . '" title = "' . $curr_team . '">';
                            echo '<img src="' . $fotos[$idx] . '" alt="" title="' . $curr_team . '" /></a> ' . $curr_title;
                        }
                        echo '</td>';
                        $idx++;
                    }
                    echo '</tr>';
                }
                echo '</table>';
                ?>			
            </main>	
        </div>        
        <footer>
            <p>Copyright &copy; 2017 Serbin Alexandr</p>
        </footer>

    </body>
</html>