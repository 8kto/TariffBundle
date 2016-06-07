/**
 * Обёртка для действия над списками задач
 */
$(function () {
    var $blocks = $('.tasks-block'),
            $tasksDone;

    /**
     * Повесить обработчики на события
     * 
     * @returns {void}
     */
    function wrapControls() {
        // Отметить выполненным
        $('.task-description .radio :radio').change(function (event) {
            event.stopImmediatePropagation();
            
            var $self = $(this),
                    taskId = $self.attr('data-task-id'),
                    $container = $self.prop('disabled', true).closest('.task-single');

            $container.addClass('muted disabled');

            $.ajax({
                url: '/ajax/done/task',
                type: 'post',
                data: {taskId: taskId},
                success: function (resp) {
                    if (resp.saved) {
                        $container.fadeOut().remove()
                    }
                    // fixme
                    else {
                        console.log(resp);
                    }
                    
                    _cleanup();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("ERROR", textStatus, errorThrown);
                }
            });
        })
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