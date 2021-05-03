require('./bootstrap');

import Vue from 'vue';
import Counties from "./components/Counties.vue";

const vue=new Vue({
    el:'#app',

    components:{

        'counties':Counties
    }

})
