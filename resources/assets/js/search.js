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
            'Lacto vegetarian', 
            'Ovo vegetarian', 
            'Pescetarian', 
            'Vegan', 
            'Vegetarian'
        ],
        cuisines: [
            'American', 
            'Italian', 
            'Asian', 
            'Mexican', 
            'Southern & Soul Food', 
            'French', 
            'Southwestern', 
            'Barbecue', 
            'Indian', 
            'Chinese', 
            'Cajun & Creole', 
            'English', 
            'Mediterranean', 
            'Greek', 
            'Spanish', 
            'German', 
            'Thai', 
            'Moroccan', 
            'Irish', 
            'Japanese', 
            'Cuban', 
            'Hawaiin', 
            'Swedish', 
            'Hungarian', 
            'Portugese'
        ],
        courses: [
            'Main Dishes', 
            'Desserts', 
            'Side Dishes', 
            'Lunch and Snacks', 
            'Appetizers', 
            'Salads', 
            'Breads', 
            'Breakfast and Brunch', 
            'Soups', 
            'Beverages', 
            'Condiments and Sauces', 
            'Cocktails'
        ],
        holidays: [
            'Christmas', 
            'Summer', 
            'Thanksgiving', 
            'New Year', 
            'Super Bowl / Game Day', 
            'Halloween', 
            'Hanukkah', 
            '4th of July'
        ],
        users_allergies: []
    },
    created: function() {
        this.allergies = allergies;
        this.users_allergies = users_allergies;
    },
    methods: {
        hasAllergy: function(allergy) {
            for (var i = 0; i < this.users_allergies.length; i++) {
                if (allergy.id == this.users_allergies[i].id)
                    return true;
            }
            return false;
        }
    }
});