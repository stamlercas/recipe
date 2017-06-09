require ('./app');

Vue.component('allergy-checkbox', require('./components/Checkbox.vue'));

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
    	]
    }
});