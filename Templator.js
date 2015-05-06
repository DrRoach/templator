var Templator = {};

Templator.load = function(filename, data, selector) {
    data = data || Templator.data;

    var template = $.ajax({
        type: 'POST',
        url: '/Ajax.php',
        data: {
            filename: filename,
            data: data
        }
    });

    template.success(function(html) {
        $(selector.selector).html(html);
    });
};

Templator.data = {};

Templator.objects = {};