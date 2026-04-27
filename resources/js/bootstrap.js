// resources/js/bootstrap.js
// Setup Axios dengan CSRF token untuk request AJAX

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
