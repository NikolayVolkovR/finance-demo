import Vue from 'vue'
import App from '../../components/demo/FinanceApp.vue'

import {store} from '../../store/demo/finance.js'
//import {router} from '../routes/airo'

/* font awesome START*/
import { library } from '@fortawesome/fontawesome-svg-core'

import { faExclamationCircle, faCheckCircle, faSpinner, faMinus, faPlus, faDownload } from '@fortawesome/free-solid-svg-icons'
import { faArrowAltCircleRight, faCircle } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faArrowAltCircleRight, faCircle, faExclamationCircle, faCheckCircle, faSpinner, faMinus, faPlus, faDownload)
/*font awesome END*/
Vue.component('font-awesome-icon', FontAwesomeIcon)

let elem = document.createElement('div');
elem.id='finance';
document.body.append(elem);

Vue.config.productionTip = false;

new Vue({
    el: '#finance',
    store,
    //router,
    components: { App },
    render: h => h(App),
}).$mount('#finance');
