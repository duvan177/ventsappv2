/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify'
import colors from 'vuetify/lib/util/colors'

import '@mdi/font/css/materialdesignicons.css'
Vue.use(Vuetify);

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

//modulo de tablas de registro de ventas y ingresos
Vue.component('dataingresos-component', require('./components/datatablas/DataIngresosComponet.vue').default);
Vue.component('dataventas-component', require('./components/datatablas/DataVentasComponet.vue').default);
//----------------------------------------------------------------------------
// Gestion de la seccion de panaderia7

Vue.component('createpan-component', require('./components/panaderia/CreatePanComponet.vue').default);
Vue.component('listpan-component', require('./components/panaderia/ListPanComponet.vue').default);
Vue.component('ingresospan-component', require('./components/panaderia/IngresoPanComponet.vue').default);
Vue.component('listbaja-component', require('./components/panaderia/BajaPanComponet.vue').default);

//-------------------------------------------------------------------------------

// seccion de informes de balance
Vue.component('balance-component', require('./components/balance/BalanceComponet.vue').default);
Vue.component('resumen-component', require('./components/balance/ResumenBalanceComponet.vue').default);




// -------------------------------------------------------------------------------------------------
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify({
            // theme: {
            //     themes: {
            //         light: {
            //             primary: colors.orange, // #E53935
            //             secondary: colors.red.lighten4, // #FFCDD2
            //             accent: colors.indigo.base, // #3F51B5
            //         },
            //     },
            // },
        }

    ),

});