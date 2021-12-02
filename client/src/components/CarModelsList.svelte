<script>
    import Alert from './Alert.svelte';
    import CarModelsListItem from './CarModelsListItem.svelte';
    import {useLocation} from 'svelte-navigator';
    import {latestCarModelsUpdate} from '../store/cars';

    const location = useLocation();

    $: fetchCarModels = async () => {
        const res = await fetch('/api/cars/get_car_models_list.php?update'+$latestCarModelsUpdate);
        if(res.status === 200){
            let data = await res.json();
            data = data.reverse();
            return data.map(c => ({
                id: c['id'],
                make: c['make'],
                model: c['model'],
                bodyType: c['body_type'],
                numberOfSeats: c['number_of_seats'],
                power: c['power'],
                transmission: c['transmission'],
            }));
        }else{
            throw new Error(await res.text());
        }
    }
</script>



<div class="car-models-list mx-0 max-h-full overflow-hidden flex flex-col">
    <h2 class="text-left m-2 text-xl font-bold text-gray-700 px-2">
        Car models list
        {#if $location.pathname === '/admin'}
            <a href='/admin/car-models' class="button-inline">
                View all <span class="material-icons top-0 relative float-right ml-1">arrow_forward</span>
            </a>
        {/if}
    </h2>
    {#await fetchCarModels()}
        <p class="text-center text-lg font-bold text-gray-400 my-8">Loading...</p>
    {:then carModels}
        <div class="overflow-y-auto flex-1 px-2 pb-2">
            <a href="/admin/car-models/add" class="button w-full shadow">
                <span class="material-icons top-0.5 relative float-left mr-1">add</span> Add new car model
            </a>
            {#each $location.pathname === '/admin' ? carModels.slice(0,6) : carModels as carModel}
                <CarModelsListItem carModel={carModel}/>
            {/each}

        </div>
    {:catch error}
        <Alert type="error">{error}</Alert>
    {/await}
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
