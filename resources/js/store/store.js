import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersist from 'vuex-persist'
import * as Cookies from 'js-cookie'
import admin from './modules/admin'
const vuexPersist = new VuexPersist({
    key: 'my-app',
    storage: localStorage
  })

Vue.use(Vuex);
//Vue.use(VuexPersistence);


const store = new Vuex.Store({
   // namespace : true,
    modules:{
        admin,
    },
    plugins: [vuexPersist.plugin]
});

export default store;