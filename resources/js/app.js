require('./bootstrap');

window.Vue = require('vue');

import Fragment from 'vue-fragment';
import Moment from 'moment';
import CounterComponent from './components/MessageCounter.vue';
import ChatComponent from './components/Chat.vue';

Vue.use(Fragment.Plugin);

Vue.filter('chatDate', function(value) {
    if (value) return ((Moment().startOf('day').diff(Moment(String(value))) < 0) ? Moment(String(value)).format('hh:mm') : Moment(String(value)).format('MM/DD/YYYY hh:mm'));
});

Vue.component('counter', CounterComponent);
Vue.component('chat', ChatComponent);

const app = new Vue({
    el: '#app',
    data: {
        messages_count: 0,
    },
    methods: {
        getCount: function () {
            let d = $.Deferred();

            axios.get('/api-admin/support/messages-count')
                .then((response) => {
                    d.resolve(response.data.count);
                });

            return d.promise();
        }
    },
});
