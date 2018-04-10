var count = 0;
/*var things = [
    {
        name: 'Веб разработка',
        price: 300,
        active:true
    },{
        name: 'Дизайн',
        price: 400,
        active:false
    },{
        name: 'Интеграция',
        price: 250,
        active:false
    },{
        name: 'Обучение',
        price: 220,
        active:false
    }
];*/
// Определяем собственный фильтр валют "currency".
Vue.filter('currency', function (value) {
    return '$' + value.toFixed(2);
});

var demo = new Vue({
    delimiters: ['${', '}'],
    el: '#main',
    data: {
        // Определяем свойства модели, представление будет проходить циклом
        // по массиву услуг и генерировать элементы списка
        // для каждого вложенного пункта.
        services: things
    },
    methods: {
        toggleActive: function(s){
            s.active = !s.active;
        },
        id_arr: function () {

            var array = [];

            this.services.forEach(function(s,key){
                if (s.active){
                    array[key] = s.id;
                }
            });
         /*   if(array.length > 1){
                $('#new').hide();
            }else{
                $('#new').show();
            }*/
            return array;
        },
        counters: function () {

            var count = 0;

            this.services.forEach(function(s){
                if (s.active){
                    count++;
                }
            });
console.log(count);
            if(count > 1){
                $('#new').hide();
            }else{
                $('#new').show();
            }
        }
    }
});


