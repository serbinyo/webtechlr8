<?php
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $idForDelete = (int) $_GET['id'];
    $thisblog = BlogModel::find($idForDelete);
    $thisblog->delete();
    $url = 'blogeditor';
    header("Location: " . $url); // предотвращаем повторную отправку формы методом GET путем перенаправления после манипуляций
}
if (isset($_POST['action']) && $_POST['action'] == 'add_new') {
    $blogValidator = new BlogValidation();
    $blogValidator->blogValidate();
    if ($blogValidator->ValidateForm()) {
        addNew();
    } else {
        $errors = true;
    }
}

function addNew() {
    $title = htmlspecialchars(trim($_POST['title']));
    $image = htmlspecialchars(trim($_POST['image']));
    $body = htmlspecialchars(trim($_POST['body']));

    $newBlog = new BlogModel();
    $newBlog->title = $title;
    $newBlog->image = $image;
    $newBlog->body = $body;
    $newBlog->save();
    header("Location: " . $_SERVER["REQUEST_URI"]); // предотвращаем повторную отправку формы методом POST путем перенаправления после манипуляций
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Редактор блога. Сайт Сербина Александра</title>
        <link rel="stylesheet" type="text/css" href="../admin/assets/css/admin_style.css">     
        <script type="text/javascript" src="../../public/assets/js/main.js"></script>
    </head>
    <body>
        <div id="wrapper">

            <main>

                <div id="current-date"></div>

                <p style="text-align: center;">
                    <a href="blogeditor" id="mybutton">Редактор блога</a><br><br>
                </p>

                <?php
                if (isset($errors)) {
                    $blogValidator->ShowErrors();
                }
                ?>


                <div class="blog_addcontainer">
                    <h3>Форма добавления публикации</h3>
                    <form action="blogeditor" method="post"  class="form">
                        <input type="hidden" name="action" value="add_new" />
                        <div class="message js-form-message"></div>

                        <div class="form-group">
                            <label class="control-label">Заголовок:*</label>
                            <div class="form-element">
                                <input type="text" class="inp" name="title" id="title" title='Обязательно к заполнению' />
                            </div>
                            <div class="clr"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Ссылка на изображение изображение:</label>
                            <div class="form-element">
                                <input type="text" name="image" class="inp" id="image" title='Не обязательно к заполнению' />
                            </div>
                            <div class="clr"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Основной текст:*</label>
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
                    echo "<div class='blog_title' id='ttl" . $blog['id'] . "'><h3>" . $blog['title'] . "</h3></div>";
                    echo "<div class='blog_image' id='img" . $blog['id'] . "'><img src='" . $blog['image'] . "'  width='250' alt='" . $blog['image'] . "'/></div>";
                    echo "<div class='blog_body' id='bdy" . $blog['id'] . "'>" . $blog['body'] . "</div>";
                    echo "<div class='blog_date'>" . $blog['date'] . "</div>";
                    echo "<div class='blog_link_container'>";
                    echo '<div class="blog_update_link" id="edit' . $blog['id'] . '" style="cursor:pointer">Редактировать</div>';
                    echo '<a class="blog_delete_link" href = blogeditor?action=delete&id=' . $blog['id'] . '>Удалить</a>';
                    echo '<div style="clear: left"></div>';
                    echo '</div>';
                    echo '</div><br>';

                    //вывод блока редактирования записи
                    echo "<div id='editablebox" . $blog['id'] . "' class='blog_addcontainer' style='display:none'>
                    <h3>Форма редактирования публикации</h3>
                    <form action='blogupdatenow?id=" . $blog['id'] . "' method='post'  class='form'>
                    <input type='hidden' name='action' value='update_row' />
                    <div class='message js-form-message'></div>

                    <div class='form-group'>
                        <label class='control-label'>Заголовок:*</label>
                        <div class='form-element'>
                            <input type='text' class='inp' name='title' id='title" . $blog['id'] . "' value = '" . $blog['title'] . "' title='Обязательно к заполнению' />
                        </div>
                        <div class='clr'></div>
                    </div>

                    <div class='form-group'>
                        <label class='control-label'>Ссылка на изображение изображение:</label>
                        <div class='form-element'>
                            <input type='text' name='image' class='inp' id='image" . $blog['id'] . "' value = '" . $blog['image'] . "' title='Не обязательно к заполнению' />
                        </div>
                        <div class='clr'></div>
                    </div>

                    <div class='form-group'>
                        <label class='control-label'>Основной текст:*</label>
                        <div class='form-element'>
                            <textarea name='body' id='body" . $blog['id'] . "' class='inp' rows='5' title='Обязательно к заполнению'>" . $blog['body'] . "</textarea>
                        </div>
                        <div class='clr'></div>
                    </div>

                    <div class='form-group'>
                        <label class='control-label'>&nbsp;</label>
                        <div class='form-element'>
                            <input id='doChng" . $blog['id'] . "' class='form-btn' value='Отредактировать' />
                            <input type='reset' id='opener' class='form-btn-clear' value='Сбросить изменения' />
                        </div>
                        <div class='clr'></div>
                    </div>
                    </form>
                </div>";
                    ?>
                    <script>
                        var btnedit<?php echo $blog['id'] ?> = document.getElementById('edit<?php echo $blog['id'] ?>'),
                                btnDoChng<?php echo $blog['id'] ?> = document.getElementById('doChng<?php echo $blog['id'] ?>');

                        btnDoChng<?php echo $blog['id'] ?>.addEventListener('click', function () {

                            if (document.getElementById('title<?php echo $blog['id'] ?>').value === '' || document.getElementById('image<?php echo $blog['id'] ?>').value === '' || document.getElementById('body<?php echo $blog['id'] ?>').value === '') {
                                alert('Заполните все поля!');
                                return false;
                            }

                            var el = document.createElement("iframe"),
                                    ttl = "<div class='blog_title' id='ttl<?php echo $blog['id'] ?>'><h3>" + document.getElementById('title<?php echo $blog['id'] ?>').value + "</h3></div>",
                                    img = "<div class='blog_image' id='img<?php echo $blog['id'] ?>'><img src='" + document.getElementById('image<?php echo $blog['id'] ?>').value + "'  width='250' alt='" + document.getElementById('image<?php echo $blog['id'] ?>').value + "'/></div>",
                                    bdy = "<div class='blog_body' id='bdy<?php echo $blog['id'] ?>'>" + document.getElementById('body<?php echo $blog['id'] ?>').value + "</div>";
                            document.body.appendChild(el);
                            el.id = 'iframe';
                            el.style.width = "1px";
                            el.style.height = "1px";
                            el.src = 'blogupdatenow?id=<?php echo $blog['id'] ?>';
                            el.onload = function () {
                                document.getElementById('editablebox<?php echo $blog['id'] ?>').style.display = 'none';
                                document.getElementById('ttl<?php echo $blog['id'] ?>').innerHTML = ttl;
                                document.getElementById('img<?php echo $blog['id'] ?>').innerHTML = img;
                                document.getElementById('bdy<?php echo $blog['id'] ?>').innerHTML = bdy;

                            };

                        });

                        btnedit<?php echo $blog['id'] ?>.addEventListener('click', function () {
                            var x = document.getElementById('editablebox<?php echo $blog['id'] ?>'),
                                    css = x.style.display;
                            if (css === 'none') {
                                x.style.display = 'block';
                            } else {
                                x.style.display = 'none';
                            }
                        });
                    </script>
                    <?php
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
                        echo '<a href="blogeditor?page=' . $i . '">' . $i . "</a> ";
                    }
                }
                echo '</p>';
                ?>


                <p style="text-align: center;">
                    <a href="blogloadfile" id="mybutton">Загрузка сообщений блога</a>
                </p>
            </main>
        </div>
        <footer>
            <p>Copyright &copy; 2017 Serbin Alexandr</p>
        </footer>

    </body>
</html>