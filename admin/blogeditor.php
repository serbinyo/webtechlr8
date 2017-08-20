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
        <script>
            function handlePopupClick() {
                window.open(this.href, 'blogupdate', 'width=980, height=550, top=50, left=50, status=no, location=no, toolbar=no, menubar=no');
                return false;
            }

            window.onload = function () {
                var lnks = document.getElementsByTagName('A')
                for (var i = 0; i < lnks.length; i++)
                    if (/\bblog_update_link\b/.test(lnks[i].className))
                        lnks[i].onclick = handlePopupClick;
            }
        </script>
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
                    echo "<div class='blog_title'><h3>" . $blog['title'] . "</h3></div>";
                    echo "<div class='blog_image'><img src='" . $blog['image'] . "'  width='250' alt='" . $blog['image'] . "'/></div>";
                    echo "<div class='blog_body'>" . $blog['body'] . "</div>";
                    echo "<div class='blog_date'>" . $blog['date'] . "</div>";
                    echo "<div class='blog_link_container'>";
                    echo '<a class="blog_update_link" href = blogupdate?id=' . $blog['id'] . ' >Редактировать</a>';
                    echo '<a class="blog_delete_link" href = blogeditor?action=delete&id=' . $blog['id'] . '>Удалить</a>';
                    echo '<div style="clear: left"></div>';
                    echo '</div>';
                    echo '</div><br>';
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