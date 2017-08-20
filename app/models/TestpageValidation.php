<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TestpageValidation extends FormValidation {

    function TestPageValidate() {

        self::addValidation("fio_php", "req", "Не заполнено ФИО");
        self::addValidation("fio_php", "fio", E_VAL_FIO_CHECK_FAILED);
        self::addValidation("groupname", "req", "Не выбрана группа");
        self::addValidation("ans1_php", "ans1", "Не выбран ответ на вопрос");
        self::addValidation("ans2_php", "ans2", E_VAL_ANS2_CHECK_FAILED);
        self::addValidation("ans2_php", "req", "Не выбран ответ на вопрос");
        self::addValidation("ans3_php", "dontselectradio", "Не выбран ответ на вопрос");
    }

}

class ResultVerification extends TestPageValidation {

    public $results;
    public $mark;

    function TestResult() {

        $ans1 = $_POST['ans1_php'];
        $ans2 = $_POST['ans2_php'];
        $ans3 = $_POST['ans3_php'];
        $marker = 0;

        if ($ans1 !== null & $ans2 !== null & $ans3 !== null) {
            if ($ans1 === 'Система типов данных') {
                $this->results['result1'] = "ДА";
                $marker++;
            } else {
                $this->results['result1'] = "НЕТ";
            }
            if ($ans2 === '3072') {
                $this->results['result2'] = "ДА";
                $marker++;
            } else {
                $this->results['result2'] = "НЕТ";
            }
            if ($ans3 === 'Никлаус Вирт') {
                $this->results['result3'] = "ДА";
                $marker++;
            } else {
                $this->results['result3'] = "НЕТ";
            }
            switch ($marker) {
                case 0: $this->mark = "Провал!";
                    break;
                case 1: $this->mark = "Удовлетворительно";
                    break;
                case 2: $this->mark = "Хорошо";
                    break;
                case 3: $this->mark = "Отлично!";
                    break;
            }
        }
    }

}
