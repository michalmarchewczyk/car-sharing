<script>
    import {navigate} from 'svelte-navigator';

    export let carModel = {};

    const openCarInfo = () => {
        navigate(`/admin/car-models/${carModel.id}`)
    }

</script>

<div class="car-models-list-item" on:click={openCarInfo}>
    <div class="w-24 flex-grow">
        <span class="car-models-list-item-name overflow-ellipsis overflow-hidden">
            {carModel.make} {carModel.model}
        </span>
        <span class="car-models-list-item-id overflow-ellipsis overflow-hidden">
            {carModel.bodyType}, {carModel.numberOfSeats} seats</span>
    </div>
    <div class="w-32 ml-4">

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
