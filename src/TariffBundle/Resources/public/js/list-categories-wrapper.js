/**
 * Обёртка для действий над списками категорий
 */
$(function () {
    var $blocks = $('.tasks-block'), _timer, 
            $tasksDone;
    var DELAY = 500;            

    /**
     * Повесить обработчики на события
     * 
     * @returns {void}
     */
    function wrapControls() { // todo invent timer on list-tasks ajax
        // [Не]Активные
        $('.btn-category-toggle').click(function (event) {
            event.stopImmediatePropagation();
            clearTimeout(_timer);

            var $self = $(this),
                    categoryId = $self.attr('data-id'),
                    $container = $self.closest('.category-single');

            $container.addClass('muted disabled');

            _timer = setTimeout(function () {
                $.ajax({
                    url: '/ajax/toggle/category',
                    type: 'post',
                    data: {id: categoryId},
                    success: function (resp) {
                        if (resp.saved) {
                            $container.fadeOut().remove()
                        }
                        // fixme
                        else {
                            console.log(resp);
                        }

//                    _cleanup();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error("ERROR", textStatus, errorThrown);
                    }
                });
            }, DELAY)
        });
    }

    /**
     * Проверить состояние списков
     * 
     * @returns {void}
     */
    function _cleanup() {
        $blocks.each(function () {
            var $self = $(this);

            // Если не осталось задач в блоке, показать надпись
            if (!$self.data('done') && !$self.children('.task-single').length && !$self.children('.tasks-empty').length) {
                if (!$tasksDone) {
                    $tasksDone = $('.tasks-done')
                }

                $self.data('done', true);
                $self.append($tasksDone.clone());
            }
        });
    }

    wrapControls();
})