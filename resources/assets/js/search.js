require ('./app');

Vue.component('allergy-checkbox', require('./components/Checkbox.vue'));
Vue.component('diet-radio', require('./components/RadioButton.vue'));
Vue.component('cuisine-checkbox', require('./components/Checkbox.vue'));
Vue.component('course-checkbox', require('./components/Checkbox.vue'));
Vue.component('holiday-checkbox', require('./components/Checkbox.vue'));
Vue.component('nutrient-input', require('./components/NutrientInput.vue'));

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
        users_diets: [],
        nutrients: [],
        nutrient_inputs: [],
        selectedNutrient: null,
        old: null
    },
    created: function() {
        this.allergies = allergies;
        this.users_allergies = users_allergies;
        this.diets = diets;
        this.users_diets = users_diets;
        this.cuisines = cuisines;
        this.courses = courses;
        this.holidays = holidays;
        this.nutrients = nutrients;
        this.nutrient_inputs = (nutrient_inputs) == null ? [] : nutrient_inputs;
        this.old = old;

        console.log(nutrient_inputs);
        console.log(this.old);
    },
    methods: {
        hasAllergy: function(allergy) {
            if (this.old.length != 0)
                return this.old[allergy.id];       //check to see if search was made before, input those values

            for (var i = 0; i < this.users_allergies.length; i++) {
                if (allergy.id == this.users_allergies[i].id)
                    return true;
            }
            return false;
        },
        hasDiet: function(diet) {
            if (this.old.length != 0)
                return this.old['diet'] == diet.id;

            for (var i = 0; i < this.users_diets.length; i++) {
                if (diet.id == this.users_diets[i].id)
                    return true;
            }
            return false;
        },
        addNutrient: function(nutrient) {
            if (nutrient != null)
                this.nutrient_inputs.push(nutrient);
        },
        removeNutrient: function(index) {
            this.nutrient_inputs.splice(index, 1);
        }
    }
});