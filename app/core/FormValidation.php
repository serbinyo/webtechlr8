<?PHP

/**
 * class ValidatorObj: Хранит информацию о каждой из форм валидации
 */
class ValidatorObj {

    var $variable_name;
    var $validator_string;
    var $error_string;

}

/** Default error messages */
define("E_VAL_REQUIRED_VALUE", "Не заполнено поле %s");
define("E_VAL_FIO_CHECK_FAILED", "Ф.И.О. должно состоять из 3-х слов кириллицей, разделенных пробелом");
define("E_VAL_TEL_CHECK_FAILED", "Телефон должен начинаться на +7 или +3 и иметь от 9 до 11 цифр");
define("E_VAL_ANS1_CHECK_FAILED", "Не выбран ответ");
define("E_VAL_ANS2_CHECK_FAILED", "Введите целочисленное значение");
define("E_VAL_EMAIL_CHECK_FAILED", "Поле Email не прошло проверку");
define("E_VAL_LESSTHAN_CHECK_FAILED", "Введите значение меньше чем %f для %s");
define("E_VAL_GREATERTHAN_CHECK_FAILED", "Введите значение больше чем %f для %s");
define("E_VAL_DONTSEL_CHECK_FAILED", "Неверный вариант для %s");

/**
 * FormValidation: Главный класс производящий валидации
 * */
class FormValidation {

    var $Rules;
    var $Errors;

    function FormValidation() {
        $this->Rules = array();
        $this->Errors = array();
    }

    function addValidation($variable, $validator, $error) {
        $validator_obj = new ValidatorObj();
        $validator_obj->variable_name = $variable;
        $validator_obj->validator_string = $validator;
        $validator_obj->error_string = $error;
        array_push($this->Rules, $validator_obj);
    }

    function GetErrors() {
        return $this->Errors;
    }

    function ValidateForm() {
        $bret = true;

        $error_string = "";
        $error_to_display = "";


        if (strcmp($_SERVER['REQUEST_METHOD'], 'POST') == 0) {
            $form_variables = $_POST;
        } else {
            $form_variables = $_GET;
        }

        $vcount = count($this->Rules);


        foreach ($this->Rules as $val_obj) {
            if (!$this->Validate($val_obj, $form_variables, $error_string)) {
                $bret = false;
                $this->Errors[$val_obj->variable_name] = $error_string;
            }
        }


        return $bret;
    }

    function Validate($validatorobj, $formvariables, &$error_string) {
        $bret = true;

        $splitted = explode("=", $validatorobj->validator_string);
        $command = $splitted[0];
        $command_value = '';

        if (isset($splitted[1]) && strlen($splitted[1]) > 0) {
            $command_value = $splitted[1];
        }

        $default_error_message = "";

        $input_value = "";

        if (isset($formvariables[$validatorobj->variable_name])) {
            $input_value = $formvariables[$validatorobj->variable_name];
        }

        $bret = $this->ValidateCommand($command, $command_value, $input_value, $default_error_message, $validatorobj->variable_name, $formvariables);


        if (false == $bret) {
            if (isset($validatorobj->error_string) &&
                    strlen($validatorobj->error_string) > 0) {
                $error_string = $validatorobj->error_string;
            } else {
                $error_string = $default_error_message;
            }
        }
        return $bret;
    }

    function isNotEmpty($input_value, &$default_error_message, $variable_name) {
        $bret = true;
        if (!isset($input_value) ||
                strlen($input_value) <= 0) {
            $bret = false;
            $default_error_message = sprintf(E_VAL_REQUIRED_VALUE, $variable_name);
        }
        return $bret;
    }

    function isEmail($email) {
        return preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email);
    }

    function isInteger($input_value, &$validation_success) {

        $more_validations = true;
        $validation_success = true;
        if (strlen($input_value) > 0) {

            if (false == is_numeric($input_value)) {
                $validation_success = false;
                $more_validations = false;
            }
        } else {
            $more_validations = false;
        }
        return $more_validations;
    }

    function isLess($command_value, $input_value, $variable_name, &$default_error_message) {
        $bret = true;
        if (false == $this->isInteger($input_value, $bret)) {
            return $bret;
        }
        if ($bret) {
            $lessthan = doubleval($command_value);
            $float_inputval = doubleval($input_value);
            if ($float_inputval >= $lessthan) {
                $default_error_message = sprintf(E_VAL_LESSTHAN_CHECK_FAILED, $lessthan, $variable_name);
                $bret = false;
            }
        }
        return $bret;
    }

    function isGreater($command_value, $input_value, $variable_name, &$default_error_message) {
        $bret = true;
        if (false == $this->isInteger($input_value, $bret)) {
            return $bret;
        }
        if ($bret) {
            $greaterthan = doubleval($command_value);
            $float_inputval = doubleval($input_value);
            if ($float_inputval <= $greaterthan) {
                $default_error_message = sprintf(E_VAL_GREATERTHAN_CHECK_FAILED, $greaterthan, $variable_name);
                $bret = false;
            }
        }
        return $bret;
    }

    function isDontSelect($input_value, $command_value, &$default_error_message, $variable_name) {
        $bret = true;
        if (is_array($input_value)) {
            foreach ($input_value as $value) {
                if ($value == $command_value) {
                    $bret = false;
                    $default_error_message = sprintf(E_VAL_DONTSEL_CHECK_FAILED, $variable_name);
                    break;
                }
            }
        } else {
            if ($command_value == $input_value) {
                $bret = false;
                $default_error_message = sprintf(E_VAL_DONTSEL_CHECK_FAILED, $variable_name);
            }
        }
        return $bret;
    }

    function checkRegexp($input_value, $reg_exp) {
        if (preg_match($reg_exp, $input_value)) {
            return true;
        }
        return false;
    }

    function ValidateCommand($command, $command_value, $input_value, &$default_error_message, $variable_name, $formvariables) {
        $bret = true;
        switch ($command) {
            case 'req': {
                    $bret = $this->isNotEmpty($input_value, $default_error_message, $variable_name);
                    break;
                }
            case 'fio': {
                    $bret = $this->checkRegexp($input_value, "/^[а-яА-Я_]+\s[а-яА-Я_]+\s[а-яА-Я_]+$/ui");
                    if (false == $bret) {
                        $default_error_message = sprintf(E_VAL_FIO_CHECK_FAILED, $variable_name);
                    }
                    break;
                }
            case 'tel': {
                    $bret = $this->checkRegexp($input_value, "/^\+(3|7)[0-9]{8,10}$/");
                    if (false == $bret) {
                        $default_error_message = sprintf(E_VAL_TEL_CHECK_FAILED, $variable_name);
                    }
                    break;
                }
            case 'ans1': {
                    $bret = $this->checkRegexp($input_value, "/^[а-яА-Я_ ]+$/ui");
                    
                    if (false == $bret) {
                        $default_error_message = sprintf(E_VAL_ANS1_CHECK_FAILED, $variable_name);
                    }
                    break;
                }
            case 'ans2': {
                    $bret = $this->checkRegexp($input_value, "/^\-?\d+$/");
                    if (false == $bret) {
                        $default_error_message = sprintf(E_VAL_ANS2_CHECK_FAILED, $variable_name);
                    }
                    break;
                }
            case 'email': {
                    if (isset($input_value) && strlen($input_value) > 0) {
                        $bret = $this->isEmail($input_value);
                        if (false == $bret) {
                            $default_error_message = E_VAL_EMAIL_CHECK_FAILED;
                        }
                    }
                    break;
                }
            case "lt":
            case "lessthan": {
                    $bret = $this->isLess($command_value, $input_value, $variable_name, $default_error_message);
                    break;
                }
            case "gt":
            case "greaterthan": {
                    $bret = $this->isGreater($command_value, $input_value, $variable_name, $default_error_message);
                    break;
                }
            case "dontselectradio": {
                    $bret = $this->isDontSelect($input_value, $command_value, $default_error_message, $variable_name);
                    break;
                }
        }
        return $bret;
    }

    function ShowErrors() {
        echo '<div class="blog_alert_container">';
        echo "<B>Ошибки валидации:</B>";
        $Errors = self::GetErrors();
        foreach ($Errors as $inpname => $inp_err) {
            echo "<p>$inpname : $inp_err</p>\r\n";
        }
        echo '</div><br>';
    }

}
