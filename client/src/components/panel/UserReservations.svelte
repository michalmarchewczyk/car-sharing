<script>
import {useLocation} from 'svelte-navigator';
import {userReservations} from '../../store/userReservations';
import UserReservationsItem from './UserReservationsItem.svelte';

const location = useLocation();

let filter = '';

$: filteredReservations = filter ? $userReservations.filter(r => r.status === filter) : $userReservations;

</script>

<div class="flex-1 flex flex-col max-w-sm max-h-full">
    <h2 class="text-left m-2 text-xl font-bold text-gray-700 px-2 mt-4 h-5 mb-4">
        My reservations
        {#if $location.pathname === '/panel'}
            <a href='/panel/reservations' class="button-inline">
                View all <span class="material-icons top-0 relative float-right ml-1">arrow_forward</span>
            </a>
        {:else}
            <select bind:value={filter}>
                <option value="">-</option>
                <option value="WAITING">WAITING</option>
                <option value="CONFIRMED">CONFIRMED</option>
                <option value="CANCELLED">CANCELLED</option>
                <option value="ACTIVE">ACTIVE</option>
                <option value="DONE">DONE</option>
            </select>
        {/if}
    </h2>
    <div class="pb-4 rounded-lg mt-4 flex flex-col w-full gap-4 flex-1 overflow-y-auto px-2">
        {#each $location.pathname === '/panel' ? $userReservations.slice(0,6) : filteredReservations as reservation}
            <UserReservationsItem reservation={reservation}/>
        {/each}
    </div>
</div>


<style lang="scss">
  .button-inline {
	@apply inline-block relative mx-3 bg-blue-700 text-white p-1.5 px-2 rounded-md hover:bg-blue-800 cursor-pointer text-base font-bold;
  }
  select{
	@apply top-0 bg-white w-32 border-2 border-gray-600 focus:border-blue-600 h-10 rounded-md text-base my-2 disabled:opacity-50 px-1 float-right mr-6;
	margin-top: -0.5rem;
  }
</style>
