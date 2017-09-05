<template>
  <div :class="type">
    <label>
      <input v-if="type === 'checkbox'" :type="type" :name="id" :checked="isChecked">
	  <input v-if="type === 'radio'" :type="type" :name="id" :checked="isChecked" :value="value">
       {{ item }}
    </label>
  </div>
</template>

<script>
export default {
	props: [
    	'item',
    	'checked',
    	'name',
    	'value',
    	'type'
	],
	computed: {
		isChecked: function() {
			if (this.checked)
				return true;
			return false;
		},
		id: function() {
			return (this.name == null) ? this.item : this.name;
		}
	}
}
</script>