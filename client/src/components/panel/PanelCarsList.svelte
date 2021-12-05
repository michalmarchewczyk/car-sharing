<script>

import {cars} from '../../store/cars';
import {useLocation} from 'svelte-navigator';
import PanelCarsListItem from './PanelCarsListItem.svelte';
import {onMount} from 'svelte';
import {resetFilters} from '../../store/carFilters';
import {filter} from '../../store/carFilters';

const location = useLocation();

onMount(() => {
    resetFilters();
})

let carsFiltered = [];

$: {
    carsFiltered = $cars;
    ['make', 'model', 'bodyType', 'numberOfSeats', 'transmission', 'color', 'availability'].forEach(key => {
        if ($filter[key] !== '') {
            carsFiltered = carsFiltered.filter(car => car[key] === $filter[key]);
        }
    });
    ['power', 'year', 'mileage', 'price'].forEach(key => {
        carsFiltered = carsFiltered.filter(car => parseFloat(car[key]) >= $filter[key+'Min'] && parseFloat(car[key]) <= $filter[key+'Max'])
    })
}


</script>

<div class="h-auto">
    <h2 class="text-left m-2 text-xl font-bold text-gray-700 px-2">
        Available cars
        {#if $location.pathname === '/panel'}
            <a href='/panel/cars' class="button-inline">
                View all <span class="material-icons top-0 relative float-right ml-1">arrow_forward</span>
            </a>
        {/if}
    </h2>
    <div class="mb-4 rounded-lg mt-4 flex flex-row w-full flex-wrap gap-6 mb-12">
        {#each $location.pathname === '/panel' ? carsFiltered.slice(0,8) : carsFiltered as car}
            <PanelCarsListItem car={car}/>
        {/each}
    </div>
</div>


<style lang="scss">
  .button-inline {
	@apply inline-block relative mx-3 bg-blue-700 text-white p-1.5 px-2 rounded-md hover:bg-blue-800 cursor-pointer text-base font-bold;
  }
</style>
