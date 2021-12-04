<script>
    import {navigate} from 'svelte-navigator';

    export let car = {};

    const openCarInfo = () => {
        navigate(`/admin/cars/${car.id}`)
    }

</script>

<div class="car-models-list-item" on:click={openCarInfo}>
    <div class="w-24 flex-grow">
        <span class="car-models-list-item-name overflow-ellipsis overflow-hidden">
            {car.make} {car.model}
        </span>
        <span class="car-models-list-item-id overflow-ellipsis overflow-hidden">
            {car.bodyType}, {car.numberOfSeats} seats, {car.power} hp, {car.transmission}</span>
        <span class="car-models-list-item-id overflow-ellipsis overflow-hidden">
            {car.color}, {car.mileage} km, {car.year} yr</span>
    </div>
    <div class="w-32 ml-4">
        <span class="pt-0 text-gray-800 text-right font-bold">{car.availability}</span>
        <span class="pt-2 text-gray-400 text-right">[id={car.id}]</span>
        <span class="pt-0 text-gray-400 text-right">[model_id={car.modelId}]</span>
    </div>
</div>

<style lang="scss">
    .car-models-list-item {
      @apply shadow-lg bg-white rounded-lg my-3 p-2 px-4 flex flex-row w-full cursor-pointer;

      &:hover {
        span {
          &.car-models-list-item-name {
            @apply text-blue-700;
          }
        }
      }
      span {
        @apply block flex-1 whitespace-nowrap;
        &.car-models-list-item-name {
          @apply text-lg font-bold text-gray-800;

        }
        &.car-models-list-item-id {
		  @apply text-base text-gray-700;
        }
	  }
      div {
        select{
          @apply bg-white w-full border-2 border-gray-600 focus:border-blue-600 h-10 rounded-md text-base my-2 disabled:opacity-50 px-1;
		}
	  }
    }

</style>
