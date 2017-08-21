<?php
Functions::add_guest_statistic();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        if (isset($_POST['action']) && $_POST['action'] == 'reg_new') {
            $userValidator = new UserValidation();
            $userValidator->userValidate();
            if ($userValidator->ValidateForm()) {
                if (checkUniqueLogin()) {
                    addNewUser();
                    ?>
                    <script type="text/javascript">
                        alert('Вы зарегистрировались');
                        window.opener.location.reload();
                        window.close();
                    </script>
                    <?php
                } else {
                    ?>
                    <script type="text/javascript">
                        alert('Логин занят');
                        document.getElementById("reg_form").reset();
                    </script>
                    <?php
                }
            } else {
                $errors = true;
            }
        }

        function checkUniqueLogin() {
            $login = htmlspecialchars(trim($_POST['login']));
            $query = "SELECT count(*) FROM users WHERE login = '$login'";
            BaseActiveRecord::check_connection();
            $total_rows = BaseActiveRecord::$pdo->query($query)->fetchColumn();
            if ($total_rows === '0') {
                return true;
            } else {
                return false;
            }
        }

        function addNewUser() {
            $fio = htmlspecialchars(trim($_POST['fio']));
            $email = htmlspecialchars(trim($_POST['email']));
            $login = htmlspecialchars(trim($_POST['login']));
            $password = htmlspecialchars(trim($_POST['password']));

            $newUser = new UsersModel();
            $newUser->fio = $fio;
            $newUser->email = $email;
            $newUser->login = $login;
            $newUser->password = $password;
            $newUser->save();
        }
        ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
        <title>Регистрация нового пользователя. Сайт Сербина Александра</title>
        <link rel="stylesheet" type="text/css" href="../../public/assets/css/style.css" >
        <script type="text/javascript" src="../../public/assets/js/main.js"></script>
        <script type="text/javascript" src="../../public/assets/js/jquery-1.4.3.min.js"></script>
        <script>
                        $(document).ready(function () {
                            $("#login").blur(function () {                         
                                $.ajax({
                                    url: "logincheck",
                                    type: "POST",
                                    data: ({name: $("#login").val()}),
                                    dataType: "html",
                                    beforeSend: function () {
                                        $("#information").text("Ожидание данных...");
                                    },
                                    success: function (data) {
                                        if (data === 'Empty') {
                                            $("#information").empty();
                                        } else if (data === 'Fail') {
                                            alert("Имя занято");
                                        } else {
                                            $("#information").text("Логин свободен");
                                        }
                                    }
                                });
                            });
                        });
        </script>
    </head>
    <body>
        <div id="wrapper">

            <main>

                <div id="current-date"></div>

                <?php
                if (isset($errors)) {
                    $userValidator->ShowErrors();
                }
                ?>


                <div class="blog_addcontainer">
                    <h3>Форма регистрации пользователя</h3>
                    <form action="registration" method="post"  class="form" id="reg_form">
                        <input type="hidden" name="action" value="reg_new" />
                        <div class="message js-form-message"></div>

                        <div class="form-group">
                            <label class="control-label">ФИО:*</label>
                            <div class="form-element">
                                <input type="text" class="inp" name="fio" id="fio" title='Обязательно к заполнению' />
                            </div>
                            <div class="clr"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Email:*</label>
                            <div class="form-element">
                                <input type="text" class="inp" name="email" id="email" title='Обязательно к заполнению' />
                            </div>
                            <div class="clr"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Логин:*</label>
                            <div class="form-element">
                                <input type="text" class="inp" name="login" id="login" title='Обязательно к заполнению' />
                                <div id="information"></div>
                            </div>
                            <div class="clr"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Пароль:*</label>
                            <div class="form-element">
                                <input type="text" class="inp" name="password" id="password" title='Обязательно к заполнению' />
                            </div>
                            <div class="clr"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">&nbsp;</label>
                            <div class="form-element">
                                <input type="submit" class="form-btn" value="Зарегистрироваться" />
                                <input type="reset" id="opener" class="form-btn-clear" value="Очистить форму" />
                            </div>
                            <div class="clr"></div>
                        </div>
                    </form>
                </div>

            </main>
        </div>
        <footer>
            <p>Copyright &copy; 2017 Serbin Alexandr</p>
        </footer>

    </body>
</html>