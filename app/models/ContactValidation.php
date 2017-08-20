<?php
/**
 * Description of blogValidation
 *
 * @author Serba
 */
class ContactValidation extends FormValidation{
    
    function ContactPageValidateRules() {

        self::addValidation("fio", "req", "Не заполнено ФИО");
        self::addValidation("fio", "fio", E_VAL_FIO_CHECK_FAILED);
        self::addValidation("gender", "dontselectradio", "Не выбран пол");
        self::addValidation("form_age", "req", "Не выбран возраст");
        self::addValidation("form_email", "req", "Не заполнено поле Email");
        self::addValidation("form_email", "email", E_VAL_EMAIL_CHECK_FAILED);
        self::addValidation("form_tel", "tel", E_VAL_TEL_CHECK_FAILED);
        self::addValidation("birthday", "req", "Не заполнено поле Дата рождения");

    }
}