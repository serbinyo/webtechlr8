<!DOCTYPE html>
<html>
    <head>
        <?php
        $idForUpdate = (int) $_GET['id'];
        $updateBlog = BlogModel::find($idForUpdate);


        if (isset($_POST['action']) && $_POST['action'] == 'update_row') {
            $blogValidator = new BlogValidation();
            $blogValidator->blogValidate();
            if ($blogValidator->ValidateForm()) {
                update($updateBlog);
                ?>
                <script type="text/javascript">window.opener.location.reload(); window.close();</script>
                <?php
            } else {
                $errors = true;
            }
        }

        function update($updateBlog) {
            $title = htmlspecialchars(trim($_POST['title']));
            $image = htmlspecialchars(trim($_POST['image']));
            $body = htmlspecialchars(trim($_POST['body']));

            $updateBlog->title = $title;
            $updateBlog->image = $image;
            $updateBlog->body = $body;
            $updateBlog->save();
        }
        ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Редактор публикации. Сайт Сербина Александра</title>
        <link rel="stylesheet" type="text/css" href="../admin/assets/css/admin_style.css">
        <script type="text/javascript" src="../../public/assets/js/main.js"></script>		
    </head>
    <body>
        <div id="wrapper">
            <main>      
                <?php
                if (isset($errors)) {
                    $blogValidator->ShowErrors();
                }
                ?>

                <div id="editablebox" class="blog_addcontainer">
                    <h3>Форма редактирования публикации</h3>
                    <form action='blogupdate?id=<?php echo $idForUpdate ?>' method='post'  class='form'>
                    <input type="hidden" name="action" value="update_row" />
                    <div class="message js-form-message"></div>

                    <div class="form-group">
                        <label class="control-label">Заголовок:*</label>
                        <div class="form-element">
                            <?php echo '<input type="text" class="inp" name="title" id="title" value = "' . $updateBlog->title . '" title="Обязательно к заполнению" />' ?>
                        </div>
                        <div class="clr"></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Ссылка на изображение изображение:</label>
                        <div class="form-element">
                            <?php echo '<input type="text" name="image" class="inp" id="image" value = "' . $updateBlog->image . '" title="Не обязательно к заполнению" />' ?>
                        </div>
                        <div class="clr"></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Основной текст:*</label>
                        <div class="form-element">
                            <?php echo '<textarea name="body" id="title" class="inp" rows="5" title="Обязательно к заполнению">' . $updateBlog->body . '</textarea>' ?>
                        </div>
                        <div class="clr"></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">&nbsp;</label>
                        <div class="form-element">
                            <input type="submit" class="form-btn" value="Отредактировать" />
                            <input type="reset" id="opener" class="form-btn-clear" value="Очистить форму" />
                        </div>
                        <div class="clr"></div>
                    </div>
                    </form>
                </div>

            </main>
        </div>
    </body>
</html>