<script>
    import {navigate, useParams} from 'svelte-navigator';
    import placeholderImage from '../../../assets/images/car_placeholder.png';
    import {changeReservationStatus, reservations} from '../../../store/reservations';

    let params = useParams();

    $: reservation = $reservations.find(reservation => reservation.id === $params.id) ?? {};

    let dateDifference = '';

    let price = 0;

    $: {
        const dif = new Date(reservation.endTime) - new Date(reservation.startTime)
        const date = new Date(dif);
        let str = '';
        if(date.getFullYear() > 1970){
            str += (date.getFullYear()-1970) + ' year';
            str += date.getFullYear() !== 1970 ? 's ' : ' ';
        }
        if(date.getMonth() > 0){
            str += date.getMonth() + ' month';
            str += date.getMonth() !== 1 ? 's ' : ' ';
        }
        if(date.getDay() > 0){
            str += date.getDate() + ' day';
            str += date.getDay() !== 1 ? 's ' : ' ';
        }
        dateDifference = str;
        price = reservation.car?.price * dif / (1000*60*60*24);
    }

    $: fetchImage = async () => {
        if(!reservation.car?.modelId) return;
        const res = await fetch('/data/photos/car_models/'+reservation.car?.modelId+'.jpg');
        if(res.status === 200){
            const data = await res.blob();
            return URL.createObjectURL(data);
        }else{
            throw new Error(await res.text());
        }
    }

    const changeStatus = async () => {
        await changeReservationStatus({id: reservation.id, status: reservation.status});
    }

</script>



<div class="reservations-info mx-0 max-h-full overflow-hidden flex flex-col">
    <div class="bg-white rounded-lg shadow-lg mx-2 my-3 mb-4 p-4 px-5 flex flex-row justify-between flex-wrap">
        <div class="float-left overflow-hidden overflow-ellipsis max-w-sm">
            <h3 class="text-3xl mb-5 mt-1 font-bold text-gray-900 whitespace-nowrap overflow-ellipsis overflow-hidden h-10">
                Reservation #{reservation.id}
            </h3>
            <span>By: <span class="font-bold">{reservation.firstName} {reservation.lastName}</span></span>
            <span>Start date: <span class="font-bold">{new Date(reservation.startTime).toLocaleDateString('en-GB')}</span></span>
            <span>End date: <span class="font-bold">{new Date(reservation.endTime).toLocaleDateString('en-GB')}</span></span>
            <span>Duration: <span class="font-bold">{dateDifference}</span></span>
            <span>Price: <span class="font-bold">{price} PLN</span></span>
            <span class="font-bold pt-2">Status:</span>
            <select bind:value={reservation.status} on:change={changeStatus} on:click|stopPropagation>
                <option value="WAITING" disabled>WAITING</option>
                <option value="CONFIRMED">CONFIRMED</option>
                <option value="CANCELLED">CANCELLED</option>
                <option value="ACTIVE">ACTIVE</option>
                <option value="DONE">DONE</option>
            </select>
            <div class="mt-2">
                <a href='/mod/reservations/edit/{$params.id}' class="button mx-2 float-left ml-0">
                    Edit dates <span class="material-icons top-0.5 relative float-right ml-3">edit</span>
                </a>
            </div>
        </div>
        <div class="reservations-info-car ml-6 flex-1 flex-shrink-0" style="min-width: 16rem">
            <h3 class="text-2xl mb-3 mt-1 font-bold text-gray-900 whitespace-nowrap overflow-ellipsis overflow-hidden h-8 text-right">
                {reservation.car?.make} {reservation.car?.model}
            </h3>
            <span class="text-right font-bold pb-2">{reservation.car?.price} PLN / day</span>
            <span class="text-right font-bold">{reservation.car?.color}</span>
            <span class="text-right font-bold">{reservation.car?.bodyType}, {reservation.car?.numberOfSeats} seats</span>
            <span class="text-right font-bold">{reservation.car?.power} hp, {reservation.car?.transmission}</span>
            <span class="text-right font-bold">{reservation.car?.mileage} km, {reservation.car?.year} yr</span>
            {#await fetchImage()}
                <img src={placeholderImage} alt="{reservation.make + ' ' + reservation.model}"
                     class="h-40 rounded-lg mb-12 float-right"/>
            {:then image}
                <div class="h-40 w-full max-w-sm mb-8 mt-4 relative flex justify-end items-center float-right overflow-hidden">
                    <img src={image} alt="{reservation.make + ' ' + reservation.model}" class="rounded-lg max-h-full"/>
                </div>
            {:catch error}
                <img src={placeholderImage} alt="{reservation.make + ' ' + reservation.model}"
                     class="h-40 rounded-lg mb-12 float-right"/>
            {/await}
<!--            <div class="block float-right">-->
<!--                <button class="button mx-2 float-right" on:click={() => {}}>-->
<!--                    Delete <span class="material-icons top-0.5 relative float-right ml-3">delete</span>-->
<!--                </button>-->
<!--                <a href='/admin/reservations/edit/{$params.id}' class="button mx-2 float-right">-->
<!--                    Edit <span class="material-icons top-0.5 relative float-right ml-3">edit</span>-->
<!--                </a>-->
<!--            </div>-->
        </div>
    </div>
</div>


<style lang="scss">
  .reservations-info {
	@apply h-auto flex-1 rounded-xl pt-2 pb-0 max-w-3xl;
	min-width: 20rem;

    > div > div > span {
      @apply text-xl text-gray-800 block my-2.5 w-full whitespace-nowrap overflow-ellipsis overflow-hidden;
    }

	> div > div.reservations-info-car > span {
	  @apply text-xl text-gray-800 block my-1 w-full whitespace-nowrap overflow-ellipsis overflow-hidden;
	}
  }

  .button {
	@apply bg-blue-700 text-white p-2 px-4 pr-3 rounded-md hover:bg-blue-800 cursor-pointer text-lg font-bold my-1;
  }

  select{
	@apply bg-white w-full border-2 border-gray-600 focus:border-blue-600 h-10 rounded-md text-base my-2 disabled:opacity-50 px-1;
  }
</style>
