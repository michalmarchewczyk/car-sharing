<script>

    import {filter, filterValues} from '../../store/carFilters';
</script>

<div class="bg-white shadow-lg p-4 mb-4 rounded-lg h-auto mt-4">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">Filter</h2>
    {#each ['make', 'model', 'bodyType', 'numberOfSeats', 'transmission', 'color', 'availability'] as key}
        <label>
            <span>{key.replace(/([A-Z])/g, " $1")}: </span>
            <select bind:value={$filter[key]}>
                <option value=""> -</option>
                {#each $filterValues[key] as filterValue}
                    <option value={filterValue}>{filterValue}</option>
                {/each}
            </select>
        </label>
    {/each}
    <!--{#each ['powerMin', 'powerMax', 'yearMin', 'yearMax', 'mileageMin', 'mileageMax', 'priceMin', 'priceMax'] as key}-->
    <!--    <label>-->
    <!--        <span>{key.replace(/([A-Z])/g, " $1")}: </span>-->
    <!--        <input type="number" bind:value={$filter[key]}/>-->
    <!--    </label>-->
    <!--{/each}-->
    {#each ['power', 'year', 'mileage', 'price'] as key}
        <div class="label-inline block flex flex-row">
                <span>{key.replace(/([A-Z])/g, " $1")}: </span>
                <input type="number" bind:value={$filter[key+'Min']} class="mr-4"/>
                <span> - </span>
                <input type="number" bind:value={$filter[key+'Max']}/>
        </div>
    {/each}


</div>


<style lang="scss">
  label {
	@apply block w-full mb-1 flex flex-row capitalize;
  }

  label > span {
	@apply text-xl text-gray-800 my-0 mr-4 whitespace-nowrap flex-shrink-0 flex-grow-0 font-bold pt-2;
  }

  input {
	@apply block flex-1 border-2 border-gray-600 focus:border-blue-600 h-10 rounded-md my-1 text-lg;
	text-indent: 0.5rem;
	flex-basis: 4rem;
	width: 2rem;
  }

  .label-inline {
    @apply capitalize mb-1;
    span {
	  @apply inline text-xl text-gray-800 my-0 mr-4 whitespace-nowrap flex-shrink-0 flex-grow-0 font-bold pt-2;
    }
    input {
      @apply inline;
    }
  }
  select {
	@apply bg-white w-full border-2 border-gray-600 focus:border-blue-600 h-10 rounded-md text-lg my-1 disabled:opacity-50 px-1;
  }
</style>
