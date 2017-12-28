require ('./app');

Vue.component('allergy-checkbox', require('./components/Checkbox.vue'));
Vue.component('diet-radio', require('./components/RadioButton.vue'));

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
        this.diets.push({ id: 'none', longDescription: 'None' });   // for someone who wants to choose no diet
        if (users_diets.length === 0)
            this.users_diets = [{ id: 'none', longDescription: 'None' }];
        else
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
            console.log(diet);
            for (var i = 0; i < this.users_diets.length; i++) {
                if (diet.id == this.users_diets[i].id)
                    return true;
            }
            return false;
        }
    }
});