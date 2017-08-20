<?php

class UserValidation extends FormValidation {

    function userValidate() {

        self::addValidation("fio", "req", "Не заполнено ФИО");
        self::addValidation("fio", "fio", E_VAL_FIO_CHECK_FAILED);
        self::addValidation("email", "req", "Не заполнено поле Email");
        self::addValidation("email", "email", E_VAL_EMAIL_CHECK_FAILED);
        self::addValidation("login", "req", "Не заполнено поле Логин");
        self::addValidation("password", "req", "Не заполнено поле Пароль");
    }

}
