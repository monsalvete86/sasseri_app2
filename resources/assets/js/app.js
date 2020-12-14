/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import Multiselect from 'vue-multiselect';

// ES6 Modules or TypeScript
import Swal from 'sweetalert2';

window.Vue = require('vue');
window.Swal = Swal;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('rol', require('./components/Rol.vue'));
Vue.component('user', require('./components/User.vue'));
Vue.component('terceros', require('./components/Terceros.vue'));
Vue.component('modulo', require('./components/Modulo.vue'));
Vue.component('plancuentas', require('./components/PlanCuentas.vue'));
Vue.component('conformatos', require('./components/ConFormatos.vue'));
Vue.component('formatos', require('./components/Formatos.vue'));
Vue.component('registroconta', require('./components/RegistroConta.vue'));
Vue.component('configgenerales', require('./components/ConfigGenerales.vue'));
Vue.component('auxiliares_conta', require('./components/AuxiliaresConta.vue'));
Vue.component('retenciones', require('./components/Retenciones.vue'));
Vue.component('colaboradores', require('./components/Colaboradores.vue'));
Vue.component('zona', require('./components/Zona.vue'));
Vue.component('bancos', require('./components/Bancos.vue'));
Vue.component('facturacion', require('./components/Facturacion.vue'));
Vue.component('articulo', require('./components/Articulo.vue'));
Vue.component('modelo_contable', require('./components/ModeloContable.vue'));
Vue.component('categoria', require('./components/Categoria.vue'));
Vue.component('presentacion', require('./components/Presentacion.vue'));
Vue.component('und_medida', require('./components/UndMedida.vue'));
Vue.component('concentracion', require('./components/Concentracion.vue'));
Vue.component('stock', require('./components/Stock.vue'));
Vue.component('ingreso', require('./components/Ingreso.vue'));
Vue.component('egreso', require('./components/Egreso.vue'));
Vue.component('cliente', require('./components/Cliente.vue'));
Vue.component('con_tarifario', require('./components/ConTarifario.vue'));
// Vue.component('tarifario', require('./components/Tarifario.vue'));
Vue.component('iva', require('./components/Iva.vue'));
Vue.component('formato_procesos', require('./components/FormatoProceso.vue'));
Vue.component('cajas', require('./components/Cajas.vue'));
Vue.component('cajas_admin', require('./components/CajasAdmin.vue'));
Vue.component('cierrescaja', require('./components/CierresXCaja.vue'));
Vue.component('informes', require('./components/Informes.vue'));
Vue.component('cuentasxcobrar', require('./components/CuentasxCobrar.vue'));
Vue.component('cuentasxpagar', require('./components/CuentasxPagar.vue'));
Vue.component('punto_venta', require('./components/PuntoVenta.vue'));
Vue.component('multiselect', Multiselect);

const app = new Vue({
    el: '#app',
    data: {
        menu: 0,
        // ruta : 'http://192.168.0.100/laravel_estudio/sistema2/public',
        // ruta : 'http://localhost/laravel_estudio/sistema2/public',
        ruta: 'http://localhost/sasseri_app2/public',
        //ruta : 'http://fractalagenciadigital.com/sistema/public',
        permisosUser: {
            'leer': 1,
            'escribir': 1,
            'crear': 1,
            'actualizar': 1,
            'anular': 1,
        }
    },
    
    mounted() {
        let me = this;
        var url = this.ruta + '/permisos/listarPermisosLogueado';
        axios.get(url).then(function(response) {
                me.permisosUser = response.data.permisosLogueado;
            })
            .catch(function(error) {
                console.log(error);
            });
    }
});