;(function () {
    'use strict';

    function Cmdb(module) {
        this.module = module;
        this.initialize();
    }

    Cmdb.prototype = {
        initialize: function() {
            this.module.on('rendered', this.rendered);
            console.log('tst');
        },
        rendered: function(event) {
            
            var $container = $('<div>');            
            $(event.target).append($container[0]);
            $('.cmdb-flatpickr').flatpickr({
                appendTo: $container[0],
                dateFormat: 'Y-m-d',
            });

            var search = $('#cmdb-search');
            
            search.on('input',() => {
                event.preventDefault();
                console.log('event input received.....');
                if (this.timeout !== undefined ) {
                    clearTimeout(this.timeout);
                }
                this.timeout = setTimeout(this.submit,400);
            });

            var searchLength = search.val().length;
            search.focus();
            search[0].setSelectionRange(searchLength,searchLength);
        },
        submit: function() {
            console.log('asdasd');
            $('#cmdb-search-form').submit();
        }
    };

    Icinga.availableModules.cmdb = Cmdb;
}());
