/**
 * Обёртка для страницы редактирования задачи
 * @todo Кнопка для последнего дня месяца
 * @todo очистить для календарей
 */
$(function(){
    var DEBUG = true;
    var $form = $('form[name=task]'),
        $taskDesc = $('#task_description'),
        $readableCt = $('#cron-readable');

        /* Чекбоксы */
    var $noDateCb = $('#task_cron_nodate'),
        $monthCb = $('#cron-month'),
        $dateCb = $('#cron-date'),
        $weekdayCb = $('#cron-weekday'),
        
        /** Все чекбоксы секций */
        $periodCbs = $('.cron-period-cb'),
        
        /** Контейнеры секций */
        $pulledCts = $('.cron-pull-ct'),    
        $weekdayCt = $('#cron-weekday-ct'),
        $dateCt = $('#cron-date-ct'),
        $monthCt = $('#cron-month-ct'),
        
        /* Контролы всех секций */
        $periodDetailsCb = $pulledCts.find(':input');

        /* Выпадающие календари */
    var $datePickers = $(".form-control.datepicker"),
        $dueDatepick = $("#task_cron_dueDate"),
        $untilDatepick = $("#task_cron_untilDate");
        
    var _timer;
    var DELAY = DEBUG? 500 : 1500;
        
    /**
     * Логирование (включено при DEBUG)
     */
    function l(){
        return (DEBUG && console && console.log && console.log.apply)
            ? console.log.apply(console, arguments) 
            : null;
    }

    /**
     * Рендерить в DOM чекбоксы для периодов
     * 
     * @returns {void}
     */
    function preparePeriodsUI(){
        /**
         * Переключенить контейнер по чекбоксу
         * 
         * @param {jQuery} $cb
         * @param {jQuery} $ct
         * @returns {void}
         */
        function _toggleCb($cb, $ct){
            var $cbs = $ct.find(':input');
            
            $cb.change(function(){
                if (!this.checked){
                    $ct.addClass('disabled');
                    $cbs.addClass('disabled');
                }
                else {
                    $ct.removeClass('disabled');
                    $cbs.removeClass('disabled');
                }

                $cbs.attr('disabled', !this.checked);
            });
        }

        // Переключение
        _toggleCb($weekdayCb, $weekdayCt);
        _toggleCb($dateCb, $dateCt);
        _toggleCb($monthCb, $monthCt);
    }

    /**
     * Включить выпадающие календари jQueryUI
     * 
     * @returns {void}
     */
    function enableDatepickers(){
        $datePickers.datepicker({
            dateFormat: 'yy-mm-dd',
            showButtonPanel: true,
            minDate: 0
        });

        // Диапазон дат
        $dueDatepick.datepicker('option', 'onClose', function (selectedDate){
            // Установить минимальную дату на день позже
            var data = $(this).datepicker('getDate'); 
            if (data) { 
                $noDateCb.prop('checked', false);
                $noDateCb.checkbox('refresh');
                
                data.setDate( data.getDate() + 1 )
                $untilDatepick.datepicker("option", "minDate", data);
            }
            else {
                $noDateCb.prop('checked', true);
                $noDateCb.checkbox('refresh');
            }
            
            checkLogic() && touchRule();
        });
        $untilDatepick.datepicker('option', 'onClose', function (selectedDate){
            if (selectedDate) {
                $noDateCb.prop('checked', false);
                $noDateCb.checkbox('refresh');
                $dueDatepick.datepicker("option", "maxDate", selectedDate);
                checkLogic() && touchRule();
            }
        });
    }

    /**
     * Установить логику для переключателей
     * 
     * @returns {void}
     */
    function setCbActions(){
        // Нет срока
        $noDateCb.change(function(){
            if (this.checked){
                $datePickers.val(null);
            }
            else {
                $dueDatepick.datepicker("show");
            }
        });
        
        // Только Число или День недели
        $dateCb.change(function(){
            $weekdayCb.prop('checked', false);
            $weekdayCt.find(':checkbox').prop('disabled', true);
        });
        $weekdayCb.change(function(){
            $dateCb.prop('checked', false);
            $dateCt.find(':checkbox').prop('disabled', true);
        });
        
        // При изменении деталей периода обновить описание правила
        $periodDetailsCb.change(touchRule);
        $periodCbs.change(touchRule);
    }

    /**
     * Установить обработчики для кнопок
     * 
     * @returns {void}
     */
    function setBtnActions(){
        /**
         * Очистить информацию о сроках
         * 
         * @param {bool} noClear Очищать календари
         * @returns {void}
         */
        function _clearDateState(noClear){
            $noDateCb.prop('checked', false);
            $noDateCb.checkbox('refresh');
            if (!noClear) $datePickers.val(null);
        }
        
        // Сегодня
        $("#btn-today").click(function(){
            _clearDateState();
            $dueDatepick.datepicker("setDate", new Date());
            checkLogic() && touchRule();
        });
        // Завтра
        $("#btn-tomorrow").click(function(){
            _clearDateState();
            $dueDatepick.datepicker("setDate", "+1d");
            checkLogic() && touchRule();
        });
        // В следующий понедельник
        $("#btn-nextweek").click(function(){
            _clearDateState();
            $dueDatepick.datepicker("setDate", '+' + (8 - new Date().getDay()));
            checkLogic() && touchRule();
        });
        
        // До понедельника
        $("#btn-until-weekend").click(function(){
            _clearDateState(true);
            $untilDatepick.datepicker("setDate", '+' + (8 - new Date().getDay()));
            checkLogic() && touchRule();
        });
        // До конца месяца
        $("#btn-until-month").click(function(){
            _clearDateState(true);
            var cur = new Date();
            
            cur.setMonth(cur.getMonth() + 1)
            cur.setDate(0);
            
            $untilDatepick.datepicker("setDate", cur);
            checkLogic() && touchRule();
        });

        /* - ПЕРИОДЫ - */
        
        // Каждый день
        $("#btn-each-day").click(function(){
            clearPeriodState();

            $weekdayCb.prop('checked', true).change();
            $weekdayCt.find(':checkbox').prop('disabled', false).prop('checked', true);
            
            checkLogic() && touchRule();
        });

        // Раз в неделю
        $("#btn-each-week").click(function(){
            clearPeriodState();

            $weekdayCb.prop('checked', true).change();
            $weekdayCt.find(':checkbox').slice(0, 1).prop('disabled', false).prop('checked', true);
            
            checkLogic() && touchRule();
        });

        // Раз в месяц
        $("#btn-each-month").click(function(){
            clearPeriodState();

            $monthCb.prop('checked', true).change();
            $monthCt.find(':checkbox').prop('disabled', false).prop('checked', true);
            
            checkLogic() && touchRule();
        });
    }
    
    /**
     * Сбросить настройки периодов
     * 
     * @returns {void}
     */
    function clearPeriodState(){
       $pulledCts.addClass('disabled')
               .find(':checkbox').prop('disabled', true).prop('checked', false);
       $periodCbs.prop('checked', false);
    }
    
    /**
     * Проверить логику переключателей, срока и периода.
     * Запускается по закрытию календарей и по нажатию кнопок
     * 
     * @returns {bool} Есть ли ошибки
     */
    function checkLogic(){
        var $ddval = $dueDatepick.val(),
            $udval = $untilDatepick.val(),
            hasErrors;
        
        // Дата От
        if ($ddval){
            // Одинаковые даты От и До
            if ($udval === $ddval){
                $untilDatepick.closest('.form-group').addClass('has-error');
                hasErrors = true;
            }
            else {
                $untilDatepick.closest('.form-group').removeClass('has-error');
            }
        }
        
        // Проверка, не пустая ли секция для активированного чекбокса
        // Убирает отметку с ненужного чекбокса
        $periodCbs.filter(':checked').each(function(){
            if ( !$('#' + this.id + '-ct :checked:first').length ){
                $(this).prop('checked', false);
                hasErrors = true;
            }
        });
        
        return !hasErrors;
    }
    
    /**
     * Запустить обновление правила, отменив предыдущее
     * 
     * @returns {void}
     */
    function touchRule(){
        clearTimeout(_timer);
        
        _timer = setTimeout(updateRuleDescription, DELAY);
    }
    
    /**
     * Получить с сервера читаемое правило повтора для задачи
     * 
     * @returns {void}
     */
    function updateRuleDescription(){
        $readableCt.fadeOut('fast');
        var collected = assembleParamsForRule();
        
        if (jQuery.isEmptyObject(collected)){
            return;
        }
        
        $.ajax({
            url : '/ajax/get/rule',
            type: 'post',
            data : {data : collected},
            success: function(resp){
                var desc = resp.desc;
                var closestDateObj = resp.closest, closest;
                
                // в интересах отладки
                if (closestDateObj){
                    if (window.Intl){ 
                        var formatter = new Intl.DateTimeFormat(undefined, {
                            weekday: "long",
                            year: "numeric",
                            month: "long",
                            day: "numeric"
                        });
                        
                        closest = formatter.format( new Date(closestDateObj.date) );
                    }
                    else {
                        closest = (new Date(closestDateObj.date)).toDateString();
                    }
                }
                
                $readableCt.html( (desc && (desc + ' | ')) + closest).fadeIn('fast');
                $taskDesc.text( 'gainerated: ' + desc + ' | ' + closest);
                l(resp)
            },
            error: function(jqXHR, textStatus, errorThrown){
               l("ERROR", textStatus, errorThrown);
            }
        });
    }
    
    /**
     * Вернуть хэш с данными для сборки правила
     * 
     * @returns {Object}
     */
    function assembleParamsForRule(){
        var params = {}, quants = {};
        
        if (!$noDateCb.is(':checked')) {
            params.dueDate = $dueDatepick.val();
            params.untilDate = $untilDatepick.val();
        }
        
        // Для отмеченных секций собираем хэш с выбранными значениями 
        // @todo вместо выборки по селектору ввести хранилище элементов
        $periodCbs.each(function(){
            if (this.checked) {
                var vals = $('#' + this.id + '-ct :checked').map(function(){
                    return this.value;
                }).get();
                
                if (vals.length) quants[this.name.substr(0, 1)] = vals;
            }
        });
        
        if (!jQuery.isEmptyObject(quants)) {
            params.quants = quants;
        }
        if (DEBUG) {
            l(params);
        }
        
        return params;
    }
    
    /**
     * Установить валидацию на форму
     * 
     * @returns {void}
     */
    function formValidation(){
        // Выставить галки для отметок Нет срока и точной даты
        $form.submit(function(){
            if (!$dueDatepick.val() && !$untilDatepick.val()){
                $noDateCb.prop('checked', true);
                $noDateCb.checkbox('refresh');
            }
        });
    }
    
    // public static void main
    preparePeriodsUI();
    enableDatepickers();
    setCbActions();
    setBtnActions();
    formValidation();
})