<script>
    import {navigate, useParams} from 'svelte-navigator';
    import placeholderImage from '../../../assets/images/car_placeholder.png';
    import {cars, deleteCar} from '../../../store/cars';

    let params = useParams();

    $: car = $cars.find(car => car.id === $params.id) ?? {};

    $: fetchImage = async () => {
        if(!car.modelId) return;
        const res = await fetch('/data/photos/car_models/'+car.modelId+'.jpg');
        if(res.status === 200){
            const data = await res.blob();
            return URL.createObjectURL(data);
        }else{
            throw new Error(await res.text());
        }
    }

    const delCar= async () => {
        const deleted = await deleteCar({id: $params.id});
        if(deleted){
            navigate('/admin/cars');
        }
    }
</script>



<div class="car-models-list mx-0 max-h-full overflow-hidden flex flex-col">
    <h2 class="text-left m-2 text-xl font-bold text-gray-700 px-2">
        Car [id={$params.id}]
    </h2>
    <div class="bg-white rounded-lg shadow-lg mx-2 my-3 mb-4 p-4 px-5 flex flex-row justify-between flex-wrap">
        <div class="float-left overflow-hidden overflow-ellipsis max-w-sm">
            <h3 class="text-3xl mb-5 mt-1 font-bold text-gray-900 whitespace-nowrap overflow-ellipsis overflow-hidden h-10">{car.make} {car.model}</h3>
            <span>Make: <span class="font-bold">{car.make}</span></span>
            <span>Model: <span class="font-bold">{car.model}</span></span>
            <span>Body type: <span class="font-bold">{car.bodyType}</span></span>
            <span>Number of seats: <span class="font-bold">{car.numberOfSeats}</span></span>
            <span>Power: <span class="font-bold">{car.power}hp </span></span>
            <span>Transmission: <span class="font-bold">{car.transmission}</span></span>
            <span>Year: <span class="font-bold">{car.year}</span></span>
            <span>Mileage: <span class="font-bold">{car.mileage}</span></span>
            <span>Color: <span class="font-bold">{car.color}</span></span>
            <span>Price: <span class="font-bold">{car.price} PLN / day</span></span>
        </div>
        <div class="ml-6 flex-1 flex-shrink-0" style="min-width: 16rem">
            <span class="text-right font-bold pb-2">{car.availability}</span>
            <span class="text-right font-bold pb-2">{car.count} {car.count === '1' ? 'person' : 'people'} waiting</span>
            {#await fetchImage()}
                <img src={placeholderImage} alt="{car.make + ' ' + car.model}"
                     class="h-60 rounded-lg mb-24 float-right"/>
            {:then image}
                <div class="h-60 w-full max-w-sm mb-20 mt-4 relative flex justify-center items-center float-right">
                    <img src={image} alt="{car.make + ' ' + car.model}" class="rounded-lg"/>
                </div>
            {:catch error}
                <img src={placeholderImage} alt="{car.make + ' ' + car.model}"
                     class="h-60 rounded-lg mb-24 float-right"/>
            {/await}
            <div class="block float-right">
                <button class="button mx-2 float-right" on:click={() => delCar()}>
                    Delete <span class="material-icons top-0.5 relative float-right ml-3">delete</span>
                </button>
                <a href='/admin/cars/edit/{$params.id}' class="button mx-2 float-right">
                    Edit <span class="material-icons top-0.5 relative float-right ml-3">edit</span>
                </a>
            </div>
        </div>
    </div>
</div>


<style lang="scss">
  .car-models-list {
	@apply h-auto flex-1 rounded-xl pt-2 pb-0 max-w-3xl;
	min-width: 20rem;

    > div > div > span {
      @apply text-xl text-gray-800 block my-2.5 w-full whitespace-nowrap overflow-ellipsis overflow-hidden;
    }
  }

  .button {
	@apply bg-blue-700 text-white p-2 px-4 pr-3 rounded-md hover:bg-blue-800 cursor-pointer text-lg font-bold my-1;
  }
</style>
