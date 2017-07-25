require ('./app');

Vue.component('recipe-media-object', require('./components/RecipeMediaObject.vue'));

const saved = new Vue({
    el: '#saved',
    data: {
    	saved_recipes: []
    },
    created: function() {
        this.saved_recipes = saved_recipes;
    }
});