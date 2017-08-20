<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GuestbookModel
 *
 * @author Serba
 */
class GuestbookValidation extends FormValidation{

    function GuestbookValidateRules() {
        self::addValidation("fio", "req", "Не заполнено ФИО");
        self::addValidation("fio", "fio", E_VAL_FIO_CHECK_FAILED);
        self::addValidation("email", "req", "Не заполнено поле Email");
        self::addValidation("email", "email", E_VAL_EMAIL_CHECK_FAILED);
        self::addValidation("body", "req", "Текст записи не может быть пустым");
    }
}
