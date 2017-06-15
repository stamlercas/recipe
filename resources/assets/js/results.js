require ('./app');

Vue.component('progress-bar', require('./components/ProgressBar.vue'));

const results = new Vue({
    el: '#results',
    data: {
    	results: [
        ]
    },
    created: function() {
        this.results = search_results.matches;
    },
    methods: {
        timeInMinutes: function(seconds) {
            return seconds / 60;
        }
    }
});