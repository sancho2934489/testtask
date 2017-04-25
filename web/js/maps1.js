/**
 * Created by sancho on 24.04.17.
 */

var myMap;

// Дождёмся загрузки API и готовности DOM.
ymaps.ready(init);

function init () {
    // Создание экземпляра карты и его привязка к контейнеру с
    // заданным id ("map").
    myMap = new ymaps.Map('map', {
        // При инициализации карты обязательно нужно указать
        // её центр и коэффициент масштабирования.
        center: [55.76, 37.64], // Москва
        zoom: 10
    }, {
        searchControlProvider: 'yandex#search'
    });

}

var createRoute = function () {
    var address1 = $('#address1').val();
    var address2 = $('#address2').val();
    ymaps.route([
        address1,
        address2
    ],{
        mapStateAutoApply: true
    }).then(function (route) {
        myMap.geoObjects.add(route);
        var distance = Math.ceil(route.getLength()/1000);
        $('#distance').val(distance);
        calcTime();
    });
};

var calcTime = function () {
    var els = $('tr[data-key]');
    var distance = $('#distance').val();
    for (var i = 0;i<els.length;i++) {
        var el = $(els[i]);
        var id = el.data('key');
        if (id) {
            console.log(id);
            var time = distance / 40;
            $.ajax({
                url: '/driver/time', //URL
                data: {
                    'id': id,
                    'distance': distance
                },
                method: 'get',
                dataType: 'json',
                success: function (data) {
                    $('#time_' + data.id).html(data.html);
                }
            });
        }
    }
};