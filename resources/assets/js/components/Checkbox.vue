<template>
  <div class="checkbox">
    <label>
      <input type="checkbox" :name="id" :checked="isChecked"> {{ item }}
    </label>
  </div>
</template>

<script>
export default {
	props: [
    	'item',
    	'checked',
    	'name'
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