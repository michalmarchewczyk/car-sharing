<script>
    import {useLocation} from 'svelte-navigator';
    import {onMount} from 'svelte';
    import {fetchReservations, reservations} from '../../../store/reservations';
    import ReservationsListItem from './ReservationsListItem.svelte';

    const location = useLocation();

    let filter = '';

    $: filteredReservations = filter ? $reservations.filter(r => r.status === filter) : $reservations;

    onMount(async () => {
        await fetchReservations();
    });
</script>



<div class="car-models-list mx-0 max-h-full overflow-hidden flex flex-col">
    <h2 class="text-left m-2 text-xl font-bold text-gray-700 px-2">
        Reservations list
        {#if $location.pathname === '/mod'}
            <a href='/mod/reservations' class="button-inline">
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
    <div class="overflow-y-scroll flex-1 px-2 pb-2">
        {#each $location.pathname === '/mod' ? $reservations.slice(0,5) : filteredReservations as reservation}
            <ReservationsListItem reservation={reservation}/>
        {:else}
            <div class="h-24 pt-12 flex-1 rounded-xl pb-0 max-w-3xl text-3xl font-bold text-gray-400 text-center " style="min-width: 20rem">
                No reservations
            </div>
        {/each}
    </div>
</div>


<style lang="scss">
  .car-models-list {
	@apply h-auto flex-1 rounded-xl pt-2 pb-0 max-w-md;
	min-width: 20rem;
  }
  .button-inline {
    @apply inline-block relative mx-3 bg-blue-700 text-white p-1.5 px-2 rounded-md hover:bg-blue-800 cursor-pointer text-base font-bold;
  }
  .button {
	@apply block text-center bg-blue-700 text-white p-2 px-4 rounded-md hover:bg-blue-800 cursor-pointer text-lg font-bold mt-3;
  }
  select{
	@apply top-0 bg-white w-32 border-2 border-gray-600 focus:border-blue-600 h-10 rounded-md text-base my-2 disabled:opacity-50 px-1 float-right mr-6;
    margin-top: -0.5rem;
  }
</style>
