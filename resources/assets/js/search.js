require ('./app');

Vue.component('allergy-checkbox', require('./components/Checkbox.vue'));
Vue.component('diet-checkbox', require('./components/Checkbox.vue'));
Vue.component('cuisine-checkbox', require('./components/Checkbox.vue'));
Vue.component('course-checkbox', require('./components/Checkbox.vue'));
Vue.component('holiday-checkbox', require('./components/Checkbox.vue'));

const search = new Vue({
    el: '#search',
    data: {
    	allergies: [
    	],
        diets: [
        ],
        cuisines: [
        ],
        courses: [
        ],
        holidays: [
        ],
        users_allergies: [],
        users_diets: []
    },
    created: function() {
        this.allergies = allergies;
        this.users_allergies = users_allergies;
        this.diets = diets;
        this.users_diets = users_diets;
        this.cuisines = cuisines;
        this.courses = courses;
        this.holidays = holidays;
    },
    methods: {
        hasAllergy: function(allergy) {
            for (var i = 0; i < this.users_allergies.length; i++) {
                if (allergy.id == this.users_allergies[i].id)
                    return true;
            }
            return false;
        },
        hasDiet: function(diet) {
            for (var i = 0; i < this.users_diets.length; i++) {
                if (diet.id == this.users_diets[i].id)
                    return true;
            }
            return false;
        }
    }
});