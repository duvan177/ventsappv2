/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify'
import '@mdi/font/css/materialdesignicons.css'
Vue.use(Vuetify, {
    iconfont: 'mdi',



});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('nav-component', require('./components/nav.vue').default);
Vue.component('alimentos-component', require('./components/almacen/alimentos.vue').default);
Vue.component('panaderia-component', require('./components/almacen/panaderia.vue').default);

// modulo de ventas de articulos
Vue.component('venta-component', require('./components/ventas/VentasComponet.vue').default);
// -------------------------------------------------------------------

//modulo de tablas de registro de ventas y usuarios
Vue.component('dataingresos-component', require('./components/datatablas/DataIngresosComponet.vue').default);
//----------------------------------------------------------------------------


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(

    ),

});