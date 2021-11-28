<script>
    export let type = 'success';
</script>

<div class:warning={type==='warning'} class:error={type==='error'} class:success={type==='success'}>
    <slot></slot>
</div>

<style lang="scss">
  div {
	@apply bg-gray-400 text-gray-700 border-2 border-gray-700 rounded-lg p-2 text-lg font-bold my-2;
	&.success {
      @apply bg-green-300 text-green-700 border-green-500;
    }
	&.warning {
	  @apply bg-yellow-300 text-yellow-700 border-yellow-500;
	}
	&.error {
	  @apply bg-red-300 text-red-700 border-red-500;
	}
  }
</style>
