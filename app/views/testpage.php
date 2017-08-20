<?php
Functions::add_guest_statistic();
session_start();

if (isset($_POST['action']) && $_POST['action'] == 'findTestable') {
    $fioForResult = htmlspecialchars(trim($_POST['fio']));
}

if (isset($_POST['action']) && $_POST['action'] == 'add_new') {
    $testValidator = new TestpageValidation();
    $testValidator->TestPageValidate();
    if ($testValidator->ValidateForm()) {
        $testResults = new ResultVerification();
        $testResults->TestResult();
        addNewTestable($testResults->results, $testResults->mark);
        header("Location: " . $_SERVER["REQUEST_URI"]); // предотвращаем повторную отправку формы методом POST путем перенаправления после манипуляций
    } else {
        $errors = true;
    }
}

function addNewTestable($results, $mark) {
    $fio = htmlspecialchars(trim($_POST['fio_php']));
    $groupname = htmlspecialchars(trim($_POST['groupname']));
    $ans1 = htmlspecialchars(trim($_POST['ans1_php']));
    $ans2 = htmlspecialchars(trim($_POST['ans2_php']));
    $ans3 = htmlspecialchars(trim($_POST['ans3_php']));

    $answers = [
        'answer1' => $ans1,
        'answer2' => $ans2,
        'answer3' => $ans3,
    ];

    $newTestable = new TestpageModel();
    $newTestable->fio = $fio;
    $newTestable->groupname = $groupname;
    $newTestable->answers = $answers;
    $newTestable->results = $results;
    $newTestable->mark = $mark;
    $newTestable->save();
}

function printTestableResult($fioForResult) {
    $flag = false;
    $query = "SELECT * FROM testpage WHERE fio = '$fioForResult' ORDER BY date DESC";
    BaseActiveRecord::check_connection();
    foreach (BaseActiveRecord::$pdo->query($query) as $i => $test) {
        echo '<div class="blog_container">';
        echo "<div class='blog_title'><h3>" . $test['fio'] . "</h3></div>";
        echo "<div class='blog_image'>" . $test['groupname'] . "</div>";
        echo "<div class='blog_body'>Вопрос 1:" . $test['result1'] . "</div>";
        echo "<div class='blog_body'>Вопрос 2:" . $test['result2'] . "</div>";
        echo "<div class='blog_body'>Вопрос 3:" . $test['result3'] . "</div>";
        echo "<div class='blog_title'><h3>Оценка:" . $test['mark'] . "</h3></div>";
        echo "<div class='blog_date'>Дата ппрохождения теста: " . $test['date'] . "</div>";
        echo '</div><br>';
        $flag = true;
    }
    if (!$flag) {
        echo '<div class="blog_alert_container"><h3>Персона не найдена</h3></div><br>';
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Тест ОПиАЯ. Сайт Сербина Александра</title>
        <link rel="stylesheet" type="text/css" href="../../public/assets/css/style.css" />
        <script type="text/javascript" src="../../public/assets/js/main.js"></script>
        <script type="text/javascript">
            window.onload = function () {
                InvalidInputHelper(document.getElementById('fio'), {
                    'change': function (val) {
                        return !val.match(/^[A-Za-z0-9а-яА-Я_]+\s[A-Za-z0-9а-яА-Я_]+\s[A-Za-z0-9а-яА-Я_]+$/gi)
                                ? "Ф.И.О. должно состоять из 3-х слов, разделенных пробелом" : "";
                    },
                });
                InvalidInputHelper(document.getElementById('ans2'), {
                    'change': function (val) {
                        return !val.match(/^\-?\d+$/g)
                                ? "Введите целочисленное значение" : "";
                    }
                });
            };
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
                ?>
                <section>

                    <?php
                    if (isset($errors)) {
                        $testValidator->ShowErrors();
                    }
                    ?>

                    <h1>Тест по дисциплине: &laquo;Основы программирования и алгоритмические языки&raquo;</h1>
                    <form action="testpage" method="post">
                        <input type="hidden" name="action" value="add_new" />
                        <div class="form-group">
                            <label class="control-label">Фамилия имя отчество:</label>
                            <div class="form-element">
                                <input type="text" name="fio_php" id="fio" value="" class="inp" autofocus />
                            </div>
                            <div class="clr"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Группа:</label>
                            <div class="form-element">
                                <select name="groupname" size="1" class="inp">
                                    <option value="">-</option>
                                    <optgroup label="1 курс">
                                        <option value="ИС-11з">ИС-11з</option>
                                        <option value="ИС-11">ИС-11</option>
                                        <option value="ИС-12">ИС-12</option>
                                    </optgroup>
                                    <optgroup label="2 курс">
                                        <option value="ИС-21з">ИС-21з</option>
                                        <option value="ИС-21">ИС-21</option>
                                        <option value="ИС-22">ИС-22</option>
                                    </optgroup>
                                    <optgroup label="3 курс">
                                        <option value="ИС-31з">ИС-31з</option>
                                        <option value="ИС-31">ИС-31</option>
                                        <option value="ИС-32">ИС-32</option>
                                    </optgroup>
                                    <optgroup label="4 курс">
                                        <option value="ИС-41з">ИС-41з</option>
                                        <option value="ИС-41">ИС-41</option>
                                        <option value="ИС-42">ИС-42</option>
                                    </optgroup>
                                    <optgroup label="5 курс">
                                        <option value="ИС-51з">ИС-51з</option>
                                        <option value="ИС-51">ИС-51</option>
                                        <option value="ИС-51">ИС-52</option>
                                    </optgroup>								
                                </select>
                            </div>
                            <div class="clr"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Основой надежного языка является:</label>
                            <div class="form-element">
                                <select name="ans1_php" size="1" class="inp">
                                    <option value="0">-</option>
                                    <option value="Гибкая система настройки">Гибкая система настройки</option>
                                    <option value="Кроссплатформенность">Кроссплатформенность</option>
                                    <option value="Система типов данных">Система типов данных</option>
                                    <option value="Совмещение нескольких парадигм программирования">Совмещение нескольких парадигм программирования</option>
                                </select>
                            </div>
                            <div class="clr"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Сколько байт в трех килобайтах:</label>
                            <div class="form-element">
                                <textarea name="ans2_php" id="ans2" rows="5" class="inp"></textarea>
                            </div>
                            <div class="clr"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Создатель языка программирования Pascal:</label>
                            <div class="form-element">
                                <label><input type="radio" name="ans3_php" value="Алан Тьюринг" />Алан Тьюринг</label><br /><br />
                                <label><input type="radio" name="ans3_php" value="Никлаус Вирт" />Никлаус Вирт</label><br /><br />
                                <label><input type="radio" name="ans3_php" value="Блез Паскаль" />Блез Паскаль</label><br /><br />
                            </div>
                            <div class="clr"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">&nbsp;</label>
                            <div class="form-element">
                                <input type="submit" value="Отправить" />
                                <input type="reset" value="Очистить форму" />
                            </div>
                            <div class="clr"></div>
                        </div>
                    </form><br><br><br><br>
                    <?php
                    if (Functions::findUser()) {
                        echo <<<EOT
                    <h1>Проверить результат:</h1> 
                    <form action="testpage" method="post">
                        <input type="hidden" name="action" value="findTestable" />
                        <div class="form-group">
                            <label class="control-label">Фамилия имя отчество:</label>
                            <div class="form-element">
                                <input type="text" name="fio" id="fio" value="" class="inp" autofocus />
                            </div>
                            <div class="clr"></div>
                        </div>
                        <input type="submit" value="Отправить" />
                    </form>
EOT;


                        if (isset($fioForResult)) {
                            printTestableResult($fioForResult);
                        }
                    }
                    ?>

                </section>
            </main>
        </div>
        <footer>
            <p>Copyright &copy; 2017 Serbin Alexandr</p>
        </footer>
    </body>
</html>