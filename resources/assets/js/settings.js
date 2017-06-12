require ('./app');

Vue.component('allergy-checkbox', require('./components/Checkbox.vue'));

const settings = new Vue({
    el: '#settings',
    data: {
    	allergies: [
    	],
        users_allergies: [
        ]
    },
    created: function() {
        this.allergies = allergies;
        this.users_allergies = users_allergies;
    },
    methods: {
        hasAllergy: function(allergy) {
            for (var i = 0; i < users_allergies.length; i++) {
                if (allergy.id == users_allergies[i].id)
                    return true;
            }
            return false;
        }
    }
});