<script>
    import placeholderImage from '../../assets/images/car_placeholder.png';

    export let car = {};

    $: modelId = car.modelId;

    $: fetchImage = async () => {
        if(!modelId) return;
        const res = await fetch('/data/photos/car_models/'+modelId+'.jpg');
        if(res.status === 200){
            const data = await res.blob();
            return URL.createObjectURL(data);
        }else{
            throw new Error(await res.text());
        }
    }

</script>

<div class="bg-white shadow-lg p-0 mb-0 rounded-lg mt-0 w-64 overflow-hidden">
    {#await fetchImage()}
        <img src={placeholderImage} alt="{car.make + ' ' + car.model}"
             class="h-32 w-full bg-white object-cover"/>
    {:then image}
        <div class="h-32 w-full bg-black flex justify-center items-center overflow-hidden">
            <img src={image} alt="{car.make + ' ' + car.model}" class="object-cover"/>
        </div>
    {:catch error}
        <img src={placeholderImage} alt="{car.make + ' ' + car.model}"
             class="h-32 w-full bg-white object-cover"/>
    {/await}
    <div class="p-3">
        <span class="text-xl font-bold">{car.make} {car.model}</span>
        <span class="font-bold">{car.price} PLN / day</span>
        <span>{car.bodyType}, {car.numberOfSeats} seats, {car.power} hp, {car.transmission}</span>
        <span>{car.color}, {car.year} yr, {car.mileage} km</span>
        <span class="font-bold">
            {car.availability}
            {#if car.availability === 'WAITING'}
                 - {car.count} {car.count === '1' ? 'person' : 'people'} waiting
            {/if}
        </span>
        <button class="button-inline" disabled={car.availability === 'RESERVED'}>
            Reserve <span class="material-icons top-0 relative float-right ml-1 text-white">arrow_forward</span>
        </button>
    </div>
</div>

<style lang="scss">
    div > span {
      @apply block text-gray-800 whitespace-nowrap overflow-hidden overflow-ellipsis;
    }
	.button-inline {
	  @apply inline-block relative mt-2 bg-blue-700 text-white p-1.5 px-2 rounded-md hover:bg-blue-800 cursor-pointer text-base font-bold;

      &:disabled {
        @apply bg-gray-400 cursor-default;
      }
	}
</style>
