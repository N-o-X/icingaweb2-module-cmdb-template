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
            console.dir(event);
            $(event.target).append($container[0]);
            $('.cmdb-flatpickr').flatpickr({
                appendTo: $container[0],
                dateFormat: 'Y-m-d',
            });
        }
    };

    Icinga.availableModules.cmdb = Cmdb;
}());
