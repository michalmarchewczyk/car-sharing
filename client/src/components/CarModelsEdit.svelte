<script>
    import placeholderImage from '../assets/images/car_placeholder.png';
    import {navigate, useParams} from 'svelte-navigator';
    import Alert from './Alert.svelte';
    import {carModels, editCarModel} from '../store/carModels';
    import InputImage from './InputImage.svelte';

    let params = useParams();

    $: carModel = $carModels.find(carModel => carModel.id === $params.id) ?? {};

    let initialized = false;

    let make = '';
    let model = '';
    let bodyType = '';
    let numberOfSeats = '';
    let power = '';
    let transmission = '';

    let newImage;

    $: newImageSrc = newImage ? URL.createObjectURL(newImage) : null;

    $: {
        if(!initialized && carModel.id) {
            initialized = true;
            make = carModel.make ?? '';
            model = carModel.model ?? '';
            bodyType = carModel.bodyType ?? '';
            numberOfSeats = carModel.numberOfSeats ?? '';
            power = carModel.power ?? '';
            transmission = carModel.transmission ?? '';
        }
    }

    const fetchImage = async () => {
        const res = await fetch('/data/photos/car_models/'+$params.id+'.jpg');
        if(res.status === 200){
            const data = await res.blob();
            return URL.createObjectURL(data);
        }else{
            throw new Error(await res.text());
        }
    }

    let error = '';
    let errorType = '';


    const submit = async () => {
        if(make === carModel.make && model === carModel.model && bodyType === carModel.bodyType && numberOfSeats === carModel.numberOfSeats
            && power === carModel.power && transmission === carModel.transmission && !newImage){
            navigate('/admin/car-models/'+$params.id);
            return;
        }
        const edited = await editCarModel({id: $params.id,
            make, model, bodyType, numberOfSeats, power, transmission, image:newImage});
        if(edited){
            navigate('/admin/car-models/'+$params.id);
        }
    }
</script>


<div class="car-models-add mx-0 max-h-full overflow-hidden flex flex-col">
    <h2 class="text-left m-2 text-xl font-bold text-gray-700 px-2">
        Edit car model [id={$params.id}]
    </h2>
    <form on:submit|preventDefault={() => {submit()}}
          class="block bg-white rounded-lg shadow-lg mx-2 my-3 mb-4 p-4 px-5 flex flex-row justify-between flex-wrap">
        <div class="float-left w-80">
            <h3 class="text-3xl mb-5 mt-1 font-bold text-gray-900">Edit car model</h3>
            <label>
                <span>Make: </span>
                <input type="text" bind:value={make} required/>
            </label>
            <label>
                <span>Model: </span>
                <input type="text" bind:value={model} required/>
            </label>
            <label>
                <span>Body type: </span>
                <input type="text" bind:value={bodyType} required/>
            </label>
            <label>
                <span>Number of seats: </span>
                <input type="number" bind:value={numberOfSeats} required/>
            </label>
            <label>
                <span>Power: </span>
                <input type="number" bind:value={power} required/>
            </label>
            <label>
                <span>Transmission: </span>
                <input type="text" bind:value={transmission} required/>
            </label>
            {#if error}
                <Alert type={errorType}>{error}</Alert>
            {/if}
        </div>
        <div class="ml-6 flex-1 flex-shrink-0" style="min-width: 16rem">
            <div class="block h-80 mb-8 flex justify-end items-center">
                {#await fetchImage()}
                    <img src={placeholderImage} alt="{make + ' ' + model}"
                         class="h-60 rounded-lg mb-2 float-right"/>
                {:then image}
                    <div class="h-60 w-full max-w-sm mb-2 relative flex justify-center items-center float-right">
                        <img src={newImageSrc ?? image ?? placeholderImage} alt="{make + ' ' + model}" class="rounded-lg"/>
                        <InputImage bind:image={newImage} title=""/>
                    </div>
                {:catch error}
                    <div class="h-60 w-full max-w-sm mb-2 relative flex justify-center items-center float-right">
                        <img src={newImageSrc ?? placeholderImage} alt="{make + ' ' + model}" class="rounded-lg"/>
                        <InputImage bind:image={newImage} title=""/>
                    </div>
                {/await}
            </div>
            <div class="block float-right">
                <button class="button mx-2 float-right" on:click|preventDefault={() => {submit()}}>
                    Save <span class="material-icons top-0.5 relative float-right ml-3">check</span>
                </button>
                <button class="button mx-2 float-right ml-4" on:click|preventDefault={() => navigate('/admin/car-models/'+$params.id)}>
                    Cancel <span class="material-icons top-0.5 relative float-right ml-3">close</span>
                </button>
            </div>
        </div>
    </form>
</div>


<style lang="scss">
  .car-models-add {
	@apply h-auto flex-1 rounded-xl pt-2 pb-0 max-w-3xl;
	min-width: 20rem;

	label {
	  @apply block w-full mb-2 flex flex-row;
	}

	label > span {
	  @apply text-xl text-gray-800 my-1 mr-4 whitespace-nowrap flex-shrink-0 flex-grow-0 font-bold;
	}

	input {
	  @apply block flex-1 border-2 border-gray-600 focus:border-blue-600 h-10 rounded-md my-1 text-lg;
	  text-indent: 0.5rem;
	  flex-basis: 4rem;
	  width: 2rem;
	}
  }

  .button {
	@apply bg-blue-700 text-white p-2 px-4 pr-3 rounded-md hover:bg-blue-800 cursor-pointer text-lg font-bold my-1;
  }
</style>
