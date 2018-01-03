require ('./app');

Vue.component('activity-item', require('./components/ActivityItem.vue'));

const app = new Vue({
    el: '#activity',
    data: {
    	activity: []
    },
    created: function() {
        this.activity = activity;
    }
});