
$(function() {

    $.validator.addMethod("fio_rule", function(value, element) {
        return this.optional(element) || (/^[а-яА-Я_]+\s[а-яА-Я_]+\s[а-яА-Я_]+$/gi).test(value);
    }, "Введите корректное ФИО");

    $.validator.addMethod("tel_rule", function(value, element) {
    return this.optional(element) || (/^\+(3|7)[0-9]{8,10}$/gi).test(value);
    }, "Введите корректный номер телефона");

    $("#js-register-form").validate({

        rules: {
            gender: {
                required: false
            },
            fio: {
                required: true,
                fio_rule: true
            },
            form_email: {
                required: true,
                email: true
            },
            form_tel: {
                required: true,
                tel_rule: true
            },
            form_age: {
                required: true,
                digits: true
            },
            birthday: {
                required: true
            },
            message: {
                required: false
            }
        },
        messages: {
            gender: {
                required: ""
            },
            fio: {
                required: "Поле Ф.И.О. обязательное для заполнения",
                fio_rule: "Ф.И.О. должно состоять из 3-х слов кириллицей, разделенных пробелом"
            },
            form_email: {
                required: "Поле E-mail обязательное для заполнения",
                email: "Введите, пожалуйста корректный e-mail"
            },
            form_tel: {
                required: "Поле Телефон обязательное для заполнения",
                tel_rule: "Телефон должен начинаться на +7 или +3 и иметь от 9 до 11 цифр"
            },
            birthday: {
                required: "Поле Дата рождения обязательное для заполнения",
            },
            form_age: {
                required: "Поле Возраст обязательное для заполнения",
                digits: "Введите, пожалуйста правильный возраст"
            }
        },
        focusCleanup: true,
        focusInvalid: false,
        invalidHandler: function(event, validator) {
            $(".js-form-message").text("Исправьте пожалуйста все ошибки.");
        },
        onkeyup: function(element) {
            $(".js-form-message").text("");
        },


    });
    
	$.datepicker.setDefaults( $.datepicker.regional[ "ru" ] );    
    $( "#datepicker" ).datepicker({
         changeMonth: true,
         changeYear: true
    });

    $("[title]").tooltip({

        position: {
        my: "left top",
        at: "right+5 top-5",
        collision: "none"
        },

        show: {
            effect: "slideDown",
            delay: 250            
        },

        hide: {
            effect: "slideUp",
            delay: 450
        }
    });


    $( "#dialog" ).dialog({
            modal:true,
            autoOpen: false,
            hide: "slideUp",
            buttons: {
                "Очистить": function() {
                    document.getElementById('js-register-form').reset(),
                    $( this ).dialog( "close" );
                },
                Отменить: function() {
                    $( this ).dialog( "close" );
                }
            }
    });

    $( "#opener" ).click(function() {
            $( "#dialog" ).dialog( "open" );
            return false;
    });

});
