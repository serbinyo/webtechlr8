<?php
/**
 * Description of blogValidation
 *
 * @author Serba
 */
class BlogValidation extends FormValidation{
    
    function blogValidate() {        
        self::addValidation("title", "req", "Не заполнен заголовок");
        self::addValidation("body", "req", "Текст записи не может быть пустым");
    }
}
