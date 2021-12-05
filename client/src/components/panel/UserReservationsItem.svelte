<script>
    import {navigate} from 'svelte-navigator';
    import {changeReservationStatus} from '../../store/reservations';

    export let reservation = {};

    let price = 0;
    let dateDifference = '';

    $: {
        const dif = new Date(reservation.endTime) - new Date(reservation.startTime)
        const diffDays = Math.ceil(dif / (1000 * 60 * 60 * 24));
        let str = '';
        str += diffDays + ' day';
        str += diffDays !== 1 ? 's ' : ' ';
        dateDifference = str;
        price = reservation.car?.price * dif / (1000*60*60*24);
    }

    const openReservationInfo = () => {
        navigate(`/panel/reservations/${reservation.id}`)
    }

    const changeStatus = async () => {
        await changeReservationStatus({id: reservation.id, status: reservation.status});
    }
</script>

<div class="user-reservations-list-item" on:click={openReservationInfo}>
    <div class="w-24 flex-grow">
        <span class="user-reservations-list-item-name overflow-ellipsis overflow-hidden">
            #{reservation.id} - {reservation.status}
        </span>
        <span class="user-reservations-list-item-id overflow-ellipsis overflow-hidden font-bold pt-0">
            {new Date(reservation.startTime).toLocaleDateString('en-GB')}
            - {new Date(reservation.endTime).toLocaleDateString('en-GB')}</span>
        <span class="user-reservations-list-item-id overflow-ellipsis overflow-hidden font-bold pt-0">
            {reservation.car?.make} {reservation.car?.model}
        </span>
        <span class="user-reservations-list-item-id overflow-ellipsis overflow-hidden">
            {reservation.car?.year} yr, {reservation.car?.mileage} km, {reservation.car?.color}
        </span>
    </div>
    <div class="w-24 ml-4">
        <span class="text-right font-bold text-gray-900">{price} PLN</span>
        <span class="text-right font-bold text-gray-600">{dateDifference}</span>
    </div>
</div>

<style lang="scss">
  .user-reservations-list-item {
	@apply shadow-lg bg-white rounded-lg my-0 p-2 px-4 flex flex-row w-full cursor-pointer;

	&:hover {
	  span {
		&.user-reservations-list-item-name {
		  @apply text-blue-700;
		}
	  }
	}
	span {
	  @apply block flex-1 whitespace-nowrap;
	  &.user-reservations-list-item-name {
		@apply text-lg font-bold text-gray-800;

	  }
	  &.user-reservations-list-item-id {
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
