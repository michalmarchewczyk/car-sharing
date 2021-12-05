<script>
import {useLocation} from 'svelte-navigator';

const location = useLocation();

</script>

<div class="flex-1 flex flex-col">
    <h2 class="text-left m-2 text-xl font-bold text-gray-700 px-2 mt-4 h-5">
        My reservations
        {#if $location.pathname === '/panel'}
            <a href='/panel/reservations' class="button-inline">
                View all <span class="material-icons top-0 relative float-right ml-1">arrow_forward</span>
            </a>
        {/if}
    </h2>
    <div class="mb-4 rounded-lg mt-4 flex flex-col w-full flex-wrap gap-4 flex-1">
        {#each [1, 2, 3] as reservation}
            <div class="bg-white shadow-lg p-4 rounded-lg w-full overflow-hidden">
                {JSON.stringify(reservation)}
            </div>
        {/each}
    </div>
</div>


<style lang="scss">
  .button-inline {
	@apply inline-block relative mx-3 bg-blue-700 text-white p-1.5 px-2 rounded-md hover:bg-blue-800 cursor-pointer text-base font-bold;
  }
</style>
