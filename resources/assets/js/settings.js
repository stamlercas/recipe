require ('./app');

Vue.component('allergy-checkbox', require('./components/Checkbox.vue'));
Vue.component('diet-checkbox', require('./components/Checkbox.vue'));

const settings = new Vue({
    el: '#settings',
    data: {
    	allergies: [
    	],
        users_allergies: [
        ],
        diets: [],
        users_diets: []
    },
    created: function() {
        this.allergies = allergies;
        this.users_allergies = users_allergies;
        this.diets = diets;
        this.users_diets = users_diets;
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
                if (diet.id == users_diets[i].id)
                    return true;
            }
            return false;
        }
    }
});