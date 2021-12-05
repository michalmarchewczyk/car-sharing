<script>
import {useLocation} from 'svelte-navigator';
import {userReservations} from '../../store/userReservations';
import UserReservationsItem from './UserReservationsItem.svelte';

const location = useLocation();

</script>

<div class="flex-1 flex flex-col max-w-sm max-h-full">
    <h2 class="text-left m-2 text-xl font-bold text-gray-700 px-2 mt-4 h-5 mb-4">
        My reservations
        {#if $location.pathname === '/panel'}
            <a href='/panel/reservations' class="button-inline">
                View all <span class="material-icons top-0 relative float-right ml-1">arrow_forward</span>
            </a>
        {/if}
    </h2>
    <div class="pb-4 rounded-lg mt-4 flex flex-col w-full gap-4 flex-1 overflow-y-auto px-2">
        {#each $location.pathname === '/panel' ? $userReservations.slice(0,6) : $userReservations as reservation}
            <UserReservationsItem reservation={reservation}/>
        {/each}
    </div>
</div>


<style lang="scss">
  .button-inline {
	@apply inline-block relative mx-3 bg-blue-700 text-white p-1.5 px-2 rounded-md hover:bg-blue-800 cursor-pointer text-base font-bold;
  }
</style>
