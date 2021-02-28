!window.Valera && (window.Valera = {});

window.Valera.Csv = function () {
    this.__init();
};

window.Valera.Csv.prototype = {

    /**
     * Инициализация класса
     * @private
     */
    __init: function () {
        this.__initBinds();
    },

    /**
     * Обработчики событий
     * @private
     */
    __initBinds: function () {
        var self = this;

        /**
         * Обработчик события нажатия на кнопку Загрузить данные из CSV-фаила
         */
        $('body').on('click', '[data-bind="save-csv"]', function (e)
        {
            self.saveCsv().then(function (result)
            {
                alert(result);
                location.reload();
            }, function(err){
                console.log('error load scripts', err);
                alert(err);
            });
        });
    },

    /**
     * Сохранение данных из CSV-фаила
     * @returns {Promise<string>}
     */
    saveCsv: function ()
    {
        return new Promise(function(resolve, reject)
        {
            $.ajax({
                url: '../assets/ajax/saveCsv.php',
                type: "POST",
                dataType: "text",
                data: {
                    ajax: "Y",
                    action: "save_csv_data"
                },
                success: function(data){
                    return resolve(data);
                },
                error: function(error){
                    console.log('error', error)
                    reject('Что-то пошло не так');
                },
            });
        });
    },
};

var csv = new Valera.Csv();