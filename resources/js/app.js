
require('./bootstrap');

window.Vue = require('vue');


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('Producto', require('./components/Producto.vue').default);
Vue.component('Compra', require('./components/Compra.vue').default);
Vue.component('Entrada', require('./components/Entrada.vue').default);
Vue.component('Salida', require('./components/Salida.vue').default);
Vue.component('Venta', require('./components/Venta.vue').default);
Vue.component('Pedido', require('./components/Pedido.vue').default);

const app = new Vue({
    el: '#app',
    data :{
        menu:0,
        ruta: 'http://localhost/existencias/public',
       }
});
