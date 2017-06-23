require ('./app');

const recipe_app = new Vue({
    el: '#recipe',
    data: {
    	recipe: {}
    },
    created: function() {
        this.recipe = recipe;
    }
});