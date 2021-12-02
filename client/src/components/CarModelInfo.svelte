<script>
    import {navigate, useParams} from 'svelte-navigator';
    import Alert from './Alert.svelte';
    import placeholderImage from '../assets/images/car_placeholder.png';
    import {createNotification} from '../store/notifications';
    import {updateCarModels} from '../store/cars';

    let params = useParams();

    $: fetchCarModel = async () => {
        const res = await fetch('/api/cars/get_car_model.php?id='+$params.id);
        if(res.status === 200){
            const data = await res.json();
            return ({
                id: data['id'],
                make: data['make'],
                model: data['model'],
                bodyType: data['body_type'],
                numberOfSeats: data['number_of_seats'],
                power: data['power'],
                transmission: data['transmission'],
            });
        }else{
            throw new Error(await res.text());
        }
    }

    $: fetchImage = async () => {
        const res = await fetch('/data/photos/car_models/'+$params.id+'.jpg');
        if(res.status === 200){
            const data = await res.blob();
            return URL.createObjectURL(data);
        }else{
            throw new Error(await res.text());
        }
    }

    const deleteCar = async () => {
        const formData = new FormData();
        formData.append('id', $params.id);
        const res = await fetch('/api/cars/delete_car_model.php', {
            method: 'POST',
            body: formData
        });
        if(res.status === 200){
            createNotification(`Deleted car model [id=${$params.id}]`, 'success');
            updateCarModels();
            navigate('/admin/car-models');
        }else{
            createNotification(`Error: ${await res.text()}`, 'error');
        }
    }
</script>



<div class="car-models-list mx-0 max-h-full overflow-hidden flex flex-col">
    <h2 class="text-left m-2 text-xl font-bold text-gray-700 px-2">
        Car model [id={$params.id}]
    </h2>
    {#await fetchCarModel()}
        <p class="text-center text-lg font-bold text-gray-400 my-8">Loading...</p>
    {:then carModel}
        <div class="bg-white rounded-lg shadow-lg mx-2 my-3 mb-4 p-4 px-5 flex flex-row justify-between flex-wrap">
            <div class="float-left">
                <h3 class="text-3xl mb-5 mt-1 font-bold text-gray-900">{carModel.make} {carModel.model}</h3>
                <span>Make: <span class="font-bold">{carModel.make}</span></span>
                <span>Model: <span class="font-bold">{carModel.model}</span></span>
                <span>Body type: <span class="font-bold">{carModel.bodyType}</span></span>
                <span>Number of seats: <span class="font-bold">{carModel.numberOfSeats}</span></span>
                <span>Power: <span class="font-bold">{carModel.power}hp </span></span>
                <span>Transmission: <span class="font-bold">{carModel.transmission}</span></span>
            </div>
            <div class="ml-6 flex-1 flex-shrink-0" style="min-width: 16rem">
                {#await fetchImage()}
                    <img src={placeholderImage} alt="{carModel.make + ' ' + carModel.model}"
                         class="h-60 rounded-lg mb-2 float-right"/>
                {:then image}
                    <div class="h-60 w-full max-w-sm mb-2 relative flex justify-center items-center float-right">
                        <img src={image} alt="{carModel.make + ' ' + carModel.model}" class="rounded-lg"/>
                    </div>
                {:catch error}
                    <img src={placeholderImage} alt="{carModel.make + ' ' + carModel.model}"
                         class="h-60 rounded-lg mb-2 float-right"/>
                {/await}
                <div class="block float-right">
                    <button class="button mx-2 float-right" on:click={() => deleteCar()}>
                        Delete <span class="material-icons top-0.5 relative float-right ml-3">delete</span>
                    </button>
                    <a href='/admin/car-models/edit/{$params.id}' class="button mx-2 float-right">
                        Edit <span class="material-icons top-0.5 relative float-right ml-3">edit</span>
                    </a>
                </div>
            </div>
        </div>
    {:catch error}
        <Alert type="error">{error}</Alert>
    {/await}
</div>


<style lang="scss">
  .car-models-list {
	@apply h-auto flex-1 rounded-xl pt-2 pb-0 max-w-3xl;
	min-width: 20rem;

    > div > div > span {
      @apply text-xl text-gray-800 block my-2.5 w-full;
    }
  }

  .button {
	@apply bg-blue-700 text-white p-2 px-4 pr-3 rounded-md hover:bg-blue-800 cursor-pointer text-lg font-bold my-1;
  }
</style>
