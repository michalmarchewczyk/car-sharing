<script>
    import {navigate, useParams} from 'svelte-navigator';
    import placeholderImage from '../../assets/images/car_placeholder.png';
    import {cars} from '../../store/cars';
    import {user} from '../../store/user';
    import {createNotification} from '../../store/notifications';
    import {addReservation} from '../../store/userReservations';
    import {currentTimestamp} from '../../store/time';

    let params = useParams();

    $: car = $cars.find(car => car.id === parseInt($params.id)) ?? {};

    let dateDifference = '';

    let startTime = new Date($currentTimestamp*1000).toISOString().substr(0,10);
    let endTime = new Date($currentTimestamp*1000 + 86400000).toISOString().substr(0,10);

    let accepted = false;

    let price = 0;

    $: {
        const dif = new Date(endTime) - new Date(startTime)
        const diffDays = Math.ceil(dif / (1000 * 60 * 60 * 24));
        let str = '';
        str += diffDays + ' day';
        str += diffDays !== 1 ? 's ' : ' ';
        dateDifference = str;
        price = car.price * dif / (1000 * 60 * 60 * 24);
    }

    $: if(new Date(endTime) <= new Date(startTime)){
        endTime = new Date(new Date(startTime).getTime() + 86400*1000).toISOString().substr(0,10);
    }

    $: fetchImage = async () => {
        if (!car.modelId) return;
        const res = await fetch('/data/photos/car_models/' + car.modelId + '.jpg');
        if (res.status === 200) {
            const data = await res.blob();
            return URL.createObjectURL(data);
        } else {
            throw new Error(await res.text());
        }
    }

    const submit = async () => {
        if(!accepted){
            createNotification('Accept Terms of Service', 'error');
            return;
        }
        let added = await addReservation({carId: $params.id, startTime: new Date(startTime), endTime: new Date(endTime)});
        if(added){
            navigate('/panel');
        }
    }
</script>


<div class="reservations-add mx-0 max-h-full overflow-hidden flex flex-col">
    <form on:submit|preventDefault={submit} class="bg-white rounded-lg shadow-lg mx-2 my-3 mb-4 p-4 px-5 flex flex-row justify-between flex-wrap">
        <div class="float-left overflow-hidden overflow-ellipsis max-w-xl w-72">
            <h3 class="text-3xl mb-5 mt-1 font-bold text-gray-900 whitespace-nowrap overflow-ellipsis overflow-hidden h-10">
                New reservation
            </h3>
            <span>By: <span class="font-bold">{$user.firstName} {$user.lastName}</span></span>
            <label class="pt-8">
                <span>Start date: </span>
                <input type="date" bind:value={startTime} required
                       min={new Date($currentTimestamp*1000).toISOString().substr(0,10)}
                       max={new Date($currentTimestamp*1000+86400*1000*360).toISOString().substr(0,10)}/>
            </label>
            <label class="pb-6">
                <span>End date: </span>
                <input type="date" bind:value={endTime} required
                       min={new Date((new Date(startTime)).getTime()+86400*1000*1).toISOString().substr(0,10)}
                       max={new Date($currentTimestamp*1000+86400*1000*361).toISOString().substr(0,10)}/>
            </label>
            <span>Duration: <span class="font-bold">{dateDifference}</span></span>
            <span>Price: <span class="font-bold">{price} PLN</span></span>
            <label class="mt-4">
                <input type="checkbox" class="w-6 h-6 mt-2 mr-4" required bind:checked={accepted}/>
                <span>I accept <a href="/about" target="_blank" class="text-blue-600">Terms of Service</a></span>
            </label>
            <div class="mt-6">
                <button class="button mx-0 clear-both float-left" on:click|preventDefault={() => {submit()}}>
                    Reserve <span class="material-icons top-0.5 relative float-right ml-3">check</span>
                </button>
            </div>
        </div>
        <div class="reservations-add-car ml-6 flex-1 flex-shrink-0" style="min-width: 16rem">
            <h3 class="text-2xl mb-3 mt-1 font-bold text-gray-900 whitespace-nowrap overflow-ellipsis overflow-hidden h-8 text-right">
                {car.make} {car.model}
            </h3>
            <span class="text-right font-bold pb-2">{car.price} PLN / day</span>
            <span class="text-right font-bold">{car.color}</span>
            <span class="text-right font-bold">{car.bodyType}, {car.numberOfSeats}
                seats</span>
            <span class="text-right font-bold">{car.power} hp, {car.transmission}</span>
            <span class="text-right font-bold">{car.mileage} km, {car.year} yr</span>
            {#await fetchImage()}
                <img src={placeholderImage} alt="{car.make + ' ' + car.model}"
                     class="h-52 rounded-lg mb-12 float-right"/>
            {:then image}
                <div class="h-52 w-full max-w-sm mb-8 mt-4 relative flex justify-end items-center float-right overflow-hidden">
                    <img src={image} alt="{car.make + ' ' + car.model}"
                         class="rounded-lg max-h-full"/>
                </div>
            {:catch error}
                <img src={placeholderImage} alt="{car.make + ' ' + car.model}"
                     class="h-52 rounded-lg mb-12 float-right"/>
            {/await}
        </div>
    </form>
</div>


<style lang="scss">
  .reservations-add {
	@apply h-auto flex-1 rounded-xl pt-2 pb-0;
	min-width: 20rem;

	> form > div > span {
	  @apply text-xl text-gray-800 block my-2.5 w-full whitespace-nowrap overflow-ellipsis overflow-hidden;
	}

	> form > div.reservations-add-car > span {
	  @apply text-xl text-gray-800 block my-1 w-full whitespace-nowrap overflow-ellipsis overflow-hidden;
	}

	label {
	  @apply block w-full mb-2 flex flex-row;
	}

	label > span {
	  @apply text-xl text-gray-800 my-1 mr-4 whitespace-nowrap flex-shrink-0 flex-grow-0 font-bold;
	}

	input:not([type='checkbox']) {
	  @apply block flex-1 border-2 border-gray-600 focus:border-blue-600 h-10 rounded-md my-1 text-lg;
	  text-indent: 0.5rem;
	  flex-basis: 4rem;
	  width: 2rem;
	}
  }

  .button {
	@apply bg-blue-700 text-white p-2 px-4 pr-3 rounded-md hover:bg-blue-800 cursor-pointer text-lg font-bold my-1;
  }

  select {
	@apply bg-white w-full border-2 border-gray-600 focus:border-blue-600 h-10 rounded-md text-base my-2 disabled:opacity-50 px-1;
  }
</style>
