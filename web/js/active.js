/**
 * Created by sancho on 23.04.17.
 */

var upActive = function (el) {
    if (!el) return false;
    var id = el.data('id');
    var active = +el.prop("checked");
    $.ajax({
        url: '/driver/active', //URL
        data: {
            'id': id,
            'active': active
        },
        method: 'get'
    });
};