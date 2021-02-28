!window.Valera && (window.Valera = {});

window.Valera.Form = function () {
    this.__init();
};

window.Valera.Form.prototype = {

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
         * Сабмит формы
         */
        $('body').on('submit', '#testForm', function (e) {
            e.preventDefault();
            let formData = $(this).serializeArray();
            self.addFormDataBlock(formData, this);

            self.sendForm(formData).then(function (result)
            {
                alert(result);
            }, function(err){
                console.log('error load scripts', err);
                alert(err);
            });
        });
    },

    /**
     * Добавление блока с данными формы
     * @param formData
     * @param form
     */
    addFormDataBlock: function (formData, form)
    {
        let $dataBlock = $('[data-block="form-data"]');
        if ($dataBlock.length) {
            $dataBlock.find('p').text(JSON.stringify(formData));
        } else {
            let formDataBlock = '<div class="row" data-block="form-data">' +
                '<div class="col-md-12">' +
                '<p>' +
                JSON.stringify(formData) +
                '</p>' +
                '</div>' +
                '</div>';
            $(form).after(formDataBlock);
        }
    },

    /**
     * Отправка формы на сервер для обработки
     * @param formData
     * @returns {Promise<string>}
     */
    sendForm: function (formData)
    {
        return new Promise(function(resolve, reject)
        {
            $.ajax({
                url: '../assets/ajax/form.php?form=' + formData,
                type: "GET",
                async: true,
                dataType: "json",
                success: function(data){
                    if (data.status === "error") {
                        return reject(data.message);
                    } else {
                        return resolve(data.message);
                    }
                },
                error: function(error){
                    console.log('error', error)
                    reject('Что-то пошло не так');
                },
            });
        });
    },
};

var form = new Valera.Form();