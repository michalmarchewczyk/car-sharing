<script>
    import {navigate} from 'svelte-navigator';
    import {changeReservationStatus} from '../../../store/reservations';

    export let reservation = {};

    const openReservationInfo = () => {
        navigate(`/mod/reservations/${reservation.id}`)
    }

    const changeStatus = async () => {
        await changeReservationStatus({id: reservation.id, status: reservation.status});
    }
</script>

<div class="reservations-list-item" on:click={openReservationInfo}>
    <div class="w-24 flex-grow">
        <span class="reservations-list-item-name overflow-ellipsis overflow-hidden">
            #{reservation.id} by {reservation.firstName} {reservation.lastName}
        </span>
        <span class="reservations-list-item-id overflow-ellipsis overflow-hidden font-bold pt-1">
            {new Date(reservation.startTime).toLocaleDateString('en-GB')}
            - {new Date(reservation.endTime).toLocaleDateString('en-GB')}</span>
        <span class="reservations-list-item-id overflow-ellipsis overflow-hidden font-bold pt-1">
            {reservation.car?.make} {reservation.car?.model}
        </span>
        <span class="reservations-list-item-id overflow-ellipsis overflow-hidden">
            {reservation.car?.year} yr, {reservation.car?.mileage} km, {reservation.car?.color}
        </span>
    </div>
    <div class="w-32 ml-4">
        <select bind:value={reservation.status} on:change={changeStatus} on:click|stopPropagation>
            <option value="WAITING" disabled>WAITING</option>
            <option value="CONFIRMED">CONFIRMED</option>
            <option value="CANCELLED">CANCELLED</option>
            <option value="ACTIVE">ACTIVE</option>
            <option value="DONE">DONE</option>
        </select>
        <span class="pt-1 text-gray-400 text-right">[user_id={reservation.userId}]</span>
        <span class="pt-0 text-gray-400 text-right">[car_id={reservation.carId}]</span>
    </div>
</div>

<style lang="scss">
  .reservations-list-item {
	@apply shadow-lg bg-white rounded-lg my-3 p-2 px-4 flex flex-row w-full cursor-pointer;

	&:hover {
	  span {
		&.reservations-list-item-name {
		  @apply text-blue-700;
		}
	  }
	}
	span {
	  @apply block flex-1 whitespace-nowrap;
	  &.reservations-list-item-name {
		@apply text-lg font-bold text-gray-800;

	  }
	  &.reservations-list-item-id {
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
