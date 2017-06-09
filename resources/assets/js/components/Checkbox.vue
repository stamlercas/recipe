<template>
  <div class="checkbox">
    <label>
      <input type="checkbox" :name="item"> {{ item }}
    </label>
  </div>
</template>

<script>
export default {
	props: [
    'item'
	]
}
</script>