<template>
  <input-field :type="'radio'" :item="item" :name="name" :checked="checked" :value="value"></input-field>
</template>

<script>
	Vue.component('input-field', require('./InputField.vue'));
export default {
	props: [
    	'item',
    	'checked',
    	'name',
    	'value',
    	'type'
	]
}
</script>