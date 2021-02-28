!window.Valera && (window.Valera = {});

window.Valera.SimplePage = function () {
    this.__init();
};

window.Valera.SimplePage.prototype = {

    firstBlock: "[data-block='first']",
    changeBlock: '[data-block="change"]',
    modal: '[data-block="change"]',

    /**
     * Инициализация класса
     * @private
     */
    __init: function () {
        this.showModal();
        this.__initBinds();
    },

    /**
     * Обработчики событий
     * @private
     */
    __initBinds: function () {
        var self = this;

        /**
         * Обработчик события нажатия кнопки 1
         */
        $('body').on('click', '[data-bind="hide-block"]', function () {
            $(self.firstBlock).toggle();
        });

        /**
         * Обработчик события нажатия кнопки 2
         */
        $('body').on('click', '[data-bind="change-block"]', function () {
            self.changeBlocks(self.changeBlock);
        });
    },

    /**
     * Смена 2х блоков местами
     * @param block
     */
    changeBlocks: function (block) {
        $(block).each(function() {
            let el;
            if ($(this).next()) {
                el = $(this).next();
            } else {
                el = $(this).prev();
            }

            var copyFrom = $(this).clone(true);
            $(el).replaceWith(copyFrom);

            var copyTo = $(el).clone(true);
            $(this).replaceWith(copyTo);
        });
    },

    /**
     * Показ модального окна
     */
    showModal: function () {
        var modalWindow = new bootstrap.Modal(document.getElementById('modalWindow'), {
            keyboard: false
        });
        modalWindow.show();
    },
};

var simplePage = new Valera.SimplePage();