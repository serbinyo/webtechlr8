<?php
Functions::add_guest_statistic();
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Обо мне. Сайт Сербина Александра</title>
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
                ?>

                <section>				
                    <h2>Сербин Александр</h2>
                    <ul>
                        <li><strong>Дата рождения:</strong> 22 марта 1988</li>
                        <li><strong>Город:</strong> Севастополь</li>
                        <li><strong>Телефон:</strong> +79788285576</li>
                        <li><strong>Эл. почта:</strong> serbinyo@gmail.com</li>
                    </ul>
                </section>

                <section>            
                    <h3>О себе</h3>
                    <ul>
                        <li>Целеустремлённость</li>
                        <li>Ответственность</li>
                        <li>Оптимизм</li>
                        <li>Обучаемость</li>
                        <li>Коммуникабельность</li>
                        <li>Креативность</li>
                        <li>Высокие знание компьютера</li>
                        <li>Имею права категории "B". Водительский стаж с 2006 года</li>
                        <li>Играю в футбол, любитель... в последнее время только на приставке... совсем в последнее время только в пас, с детьми...</li>
                    </ul>
                </section>

                <section>            
                    <h3>Работа</h3>
                    <p>Технический специалист по обслуживанию платежных терминалов.</p>
                </section>

                <section>
                    <h3>Образование</h3>
                    <p><strong>Высшее</strong></p>
                    <p>В 2013 году окончил Севастопольский национальный технический университет по специальности <strong>"Радиотехника"</strong>.</p>
                    <p>В 2016 поступил в Севастопольский государственный университет на 3 курс специальность <strong>"Информационные системы"</strong>.</p>
                </section>            

                <section>
                    <h3>Дополнительное образование </h3>
                    <p>В 2012 году окончил курс обучения по программе <strong>"Web-программирование"</strong> в СНТУ Festo.</p>
                </section>  

                <section>
                    <h3>Владение языками</h3>
                    <p><strong>Русский</strong> - родной</p>               
                    <p><strong>Английский</strong> - хороший</p>
                </section>

            </main>
        </div>
        <footer>
            <p>Copyright &copy; 2017 Serbin Alexandr</p>
        </footer>

    </body>
</html>