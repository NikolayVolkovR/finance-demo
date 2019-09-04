import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios'
import CamelToKebab from '../../helpers/camelToKebab'

Vue.use(Vuex);

axios.defaults.baseURL = getCorsBaseUrl();
axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
axios.defaults.headers.common['Access-Control-Allow-Methods'] = 'GET,PUT,POST,DELETE,PATCH,OPTIONS';
axios.defaults.headers.common['Access-Control-Allow-Headers'] = 'Origin, Accept, Content-Type, Authorization, Access-Control-Allow-Origin';
axios.defaults.headers.common['Access-Control-Allow-Credentials'] = 'include';
axios.defaults.responseType = 'json';
axios.defaults.withCredentials = true;

export const store = new Vuex.Store({
    state: {

    },
    getters: {
        data(state) {
            return state.data ? state.data : null;
        },
    },
    mutations: {
        setData(state, {data}) {
            Vue.set(state, 'data', data);
        },
        handleError(state, {error}) {
            // Error
            if (error.response) {
                // The request was made and the server responded with a status code
                // that falls out of the range of 2xx
                //console.log(1, error.response.data);
                console.log(1, error.response.data.message);
                // console.log(error.response.status);
                // console.log(error.response.headers);
            } else if (error.request) {
                // The request was made but no response was received
                // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                // http.ClientRequest in node.js
                console.log(2, error.request);
            } else {
                // Something happened in setting up the request that triggered an Error
                console.log(3, 'Error', error.message);
            }
            //console.log(error.config);
        },
    },
    actions: {
        getData(store) {
            let url = '/demo/finance/get-data' ;
            axios.get(url)
                .then(response => {
                    store.commit('setData', {data: response.data})
                })
                .catch(error => {
                    store.commit('handleError', {error: error})
                });
        },
        saveData(store, {color, email, name}) {
            let url = '/demo/finance/save-data';
            axios.post(url, {color, email, name})
                .then(response => {
                    store.dispatch('getData');
                    alert(response.data)
                })
                .catch(error => {
                    store.commit('handleError', {error: error})
                });
        },
    },
    strict: process.env.NODE_ENV !== 'production'
});

function getCorsBaseUrl() {
    if (location.hostname.indexOf('movements.ru') >= 0) {
        return 'http://api.movements.ru';
    } else {
        return 'http://dev-api.chasovye-mehanizmy.ru';
    }
}



