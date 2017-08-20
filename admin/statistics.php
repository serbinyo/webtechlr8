<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Статистика посещений. Сайт Сербина Александра</title>
        <link rel="stylesheet" type="text/css" href="../admin/assets/css/admin_style.css">
        <script type="text/javascript" src="../../public/assets/js/main.js"></script>		
    </head>
    <body>
        <div id="wrapper">

            <main>

                <div id="current-date"></div>

                <?php
                // количество записей, выводимых на странице
                $per_page = 25;
                // получаем номер страницы
                $page = (int) (isset($_GET['page']) ? ($_GET['page'] - 1) : 0);
                // вычисляем первый операнд для LIMIT
                $start = abs($page * $per_page);

                // выполняем запрос и выводим записи
                $query = "SELECT * FROM statistics ORDER BY date DESC LIMIT $start, $per_page";

                BaseActiveRecord::check_connection();
                echo '<table  class="table-study">';
                echo '<tr class="topic"><td>Страница</td><td>IP посетителя</td><td>Host посетителя</td><td>Информация о браузере</td><td>Дата посещения</td></tr>';
                foreach (BaseActiveRecord::$pdo->query($query) as $i => $statistic) {
                    
                    echo "<tr><td>" . $statistic['page'] . "</td>";
                    echo "<td>" . $statistic['ip'] . "</td>";
                    echo "<td>" . $statistic['host'] . "</td>";
                    echo "<td>" . $statistic['browser_name'] . "</td>";
                    echo "<td>" . $statistic['date'] . "</td></tr>";
                    
                }
                echo '</table>';
                // выводим ссылки на страницы:
                $query = "SELECT count(*) FROM statistics";
                $total_rows = BaseActiveRecord::$pdo->query($query)->fetchColumn();

                // Определяем общее количество страниц
                $num_pages = ceil($total_rows / $per_page);

                echo '<p>Страницы: ';
                for ($i = 1; $i <= $num_pages; $i++) {
                    // текущую страницу выводим без ссылки
                    if ($i - 1 == $page) {
                        echo $i . " ";
                    } else {
                        echo '<a href="statistics?page=' . $i . '">' . $i . "</a> ";
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