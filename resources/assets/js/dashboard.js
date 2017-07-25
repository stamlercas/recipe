require ('./app');

Vue.component('save-icon', require('./components/SaveIcon.vue'));

const homepage = new Vue({
    el: '#dashboard',
    data: {
    	trending: []
    },
    created: function() {
        this.trending = trending;
    }
});