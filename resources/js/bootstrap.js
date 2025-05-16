import axios from 'axios';
import * as lucide from 'lucide';
window.axios = axios;
window.lucide = lucide;


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
