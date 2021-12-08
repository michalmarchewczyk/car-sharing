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
let sort = '';

$: {
    carsFiltered = $cars;
    carsFiltered = carsFiltered.filter(car => car['availability'] !== 'RESERVED');
    ['make', 'model', 'bodyType', 'numberOfSeats', 'transmission', 'color', 'availability'].forEach(key => {
        if ($filter[key] !== '') {
            carsFiltered = carsFiltered.filter(car => car[key] === $filter[key]);
        }
    });
    ['power', 'year', 'mileage', 'price'].forEach(key => {
        carsFiltered = carsFiltered.filter(car => parseFloat(car[key]) >= $filter[key+'Min'] && parseFloat(car[key]) <= $filter[key+'Max'])
    })
    if(sort){
        if(sort === 'priceAsc'){
            carsFiltered = carsFiltered.sort((a,b) => (a.price - b.price));
        }else if(sort === 'priceDesc'){
            carsFiltered = carsFiltered.sort((a,b) => (b.price - a.price));
        }else if(sort === 'yearAsc'){
            carsFiltered = carsFiltered.sort((a,b) => (a.year - b.year));
        }else if(sort === 'yearDesc'){
            carsFiltered = carsFiltered.sort((a,b) => (b.year - a.year));
        }
    }
}


</script>

<div class="h-auto">
    <h2 class="text-left m-2 text-xl font-bold text-gray-700 px-2">
        Cars
        {#if $location.pathname === '/panel'}
            <a href='/panel/cars' class="button-inline">
                View all <span class="material-icons top-0 relative float-right ml-1">arrow_forward</span>
            </a>
        {:else}
            ({carsFiltered.length})
            <label class="float-right mr-4">
                <span>Sort by:</span>
                <select bind:value={sort}>
                    <option value=""> - </option>
                    <option value="priceAsc">Price (asc)</option>
                    <option value="priceDesc">Price (desc)</option>
                    <option value="yearAsc">Year (asc)</option>
                    <option value="yearDesc">Year (desc)</option>
                </select>
            </label>
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
  select{
	@apply top-0 bg-white w-32 border-2 border-gray-600 focus:border-blue-600 h-10 rounded-md text-base my-2 disabled:opacity-50 px-1 float-right mr-6 ml-4;
    margin-top: -0.25rem;
  }
</style>
