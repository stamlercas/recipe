require ('./app');

Vue.component('allergy-checkbox', require('./components/Checkbox.vue'));
Vue.component('diet-checkbox', require('./components/Checkbox.vue'));
Vue.component('cuisine-checkbox', require('./components/Checkbox.vue'));

const search = new Vue({
    el: '#search',
    data: {
    	allergies: [
    		'Dairy', 
    		'Egg', 
    		'Gluten', 
    		'Peanut', 
    		'Seafood', 
    		'Sesame', 
    		'Soy', 
    		'Sulfite', 
    		'Tree Nut', 
    		'Wheat'
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
        ]
    }
});