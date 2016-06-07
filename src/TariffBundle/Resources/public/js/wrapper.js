/**
 * Глобальная обёртка
 */
$(function () {
    // Красивые чекбоксы
    $(':checkbox').checkbox({
        buttonStyle: 'btn-link btn-large',
        checkedClass: 'icon-ok-squared',
        uncheckedClass: 'icon-check-empty'
    });

    // Красивые радио
    $(':radio').radio({
        buttonStyle: 'btn-link btn-large',
        checkedClass: 'icon-dot-circled',
        uncheckedClass: 'icon-circle-empty',
        labelClass: "radio bootstrap-radio"
//        buttonStyleChecked: null,
//        displayAsButton: false,
//        labelClassChecked: "active"
    });

    // Красивые селекты
    $('select').selectpicker({
        style: 'btn-success btn-sm',
        size: 5
    });
    
    // Активировать выпадающие меню
    $('.dropdown-toggle').dropdown();
});