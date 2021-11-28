<script>
    import { fly } from 'svelte/transition';
    import { quadOut } from 'svelte/easing';

    export let type = '';
</script>

<div type={type}
     in:fly={{duration:100, x: -100, y: 0, opacity: 0.5, easing: quadOut}}
     out:fly={{duration:100, x: 100, y: 0, opacity: 0.5, easing: quadOut}}
     class:success={type==='success'}
     class:warning={type==='warning'}
     class:error={type==='error'}
>
    <slot></slot>
</div>

<style lang="scss">
    div {
      @apply shadow-xl bg-gray-900 w-full h-12 my-1.5 text-white whitespace-nowrap
      rounded-xl p-2.5 px-4 text-base text-gray-200 font-bold overflow-hidden overflow-ellipsis;
      &.success {
        @apply bg-green-600 text-gray-100;
      }
	  &.warning {
		@apply bg-yellow-600 text-gray-100;
	  }
	  &.error {
		@apply bg-red-600 text-gray-100;
	  }
    }
</style>
