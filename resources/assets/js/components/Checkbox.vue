<template>
  <div class="checkbox">
    <label>
      <input type="checkbox" :name="item" :checked="isChecked"> {{ item }}
    </label>
  </div>
</template>

<script>
export default {
	props: [
    	'item',
    	'checked'
	],
	computed: {
		isChecked: function() {
			if (this.checked)
				return true;
			return false;
		}
	}
}
</script>