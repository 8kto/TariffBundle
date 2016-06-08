/**
 * 
 * @link http://symfony.com/doc/2.8/cookbook/form/form_collections.html
 */
$(function () {
    // setup an "add" link
    var $addLink = $('#btn-add-feature');
    var $newRow = $('<div class="row-fluid feature-row"></div>');
    var $collectionCt = $('.features-list');

    // add a delete link to all of the existing tag form li elements
    $collectionCt.find('.feature-row').each(function () {
        addFormDeleteLink($(this));
    });

    $collectionCt.append($newRow);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionCt.data('index', $collectionCt.find(':input').length);

    $addLink.on('click', function (e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new form (see next code block)
        addNewForm($collectionCt, $newRow);
    });

    /**
     * Создать новую форму для добавления возм.
     * 
     * @param {jQuery} $collectionCt
     * @param {jQuery} $newRow
     * @returns {void}
     */
    function addNewForm($collectionCt, $newRow) {
        // Get the data-prototype explained earlier
        var prototype = $collectionCt.data('prototype');

        // get the new index
        var index = $collectionCt.data('index');

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        $collectionCt.data('index', index + 1);

        // Display the form in the page in an li, before the "Add" link li
        var $newFormRow = $('<div class="row-fluid feature-row"></div>').append(newForm);
        $newRow.before($newFormRow);

        $newFormRow.find('select').selectpicker({
            style: 'btn-info',
            size: 8
        });

        // add a delete link to the new form
        addFormDeleteLink($newFormRow);
    }

    /**
     * Добавить кнопку удаления формы
     * 
     * @param {jQuery} $row
     * @returns {void}
     */
    function addFormDeleteLink($row) {
        var $removeLink = $('<a href="#" class="btn btn-danger btn-xs">Удалить</a>');
        $row.append($removeLink);

        $removeLink.on('click', function (e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();

            // remove the li for the tag form
            $row.remove();
        });
    }

});