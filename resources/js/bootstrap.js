import axios from 'axios';
window.axios = axios;

//IMPORTANTE: Agregar estas lineas de codigo para que funcione el select2
import $ from 'jquery';
window.jQuery = window.$ = $;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
