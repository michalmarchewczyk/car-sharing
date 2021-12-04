<script>
    import {useLocation} from 'svelte-navigator';
    import {onMount} from 'svelte';
    import {cars, fetchCars} from '../../../store/cars';
    import CarsListItem from './CarsListItem.svelte';

    const location = useLocation();

    onMount(async () => {
        console.log('LOAD CARS');
        await fetchCars();
    });
</script>



<div class="car-models-list mx-0 max-h-full overflow-hidden flex flex-col">
    <h2 class="text-left m-2 text-xl font-bold text-gray-700 px-2">
        Cars list
        {#if $location.pathname === '/admin'}
            <a href='/admin/cars' class="button-inline">
                View all <span class="material-icons top-0 relative float-right ml-1">arrow_forward</span>
            </a>
        {/if}
    </h2>
    <div class="overflow-y-auto flex-1 px-2 pb-2">
        <a href="/admin/cars/add" class="button w-full shadow">
            <span class="material-icons top-0.5 relative float-left mr-1">add</span> Add new car
        </a>
        {#each $location.pathname === '/admin' ? $cars.slice(0,5) : $cars as car}
            <CarsListItem car={car}/>
        {:else}
            <div class="h-24 pt-12 flex-1 rounded-xl pb-0 max-w-3xl text-3xl font-bold text-gray-400 text-center " style="min-width: 20rem">
                No cars
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
</style>
