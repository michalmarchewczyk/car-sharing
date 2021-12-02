<script>
    import placeholderImage from '../assets/images/car_placeholder.png';
    import {navigate} from 'svelte-navigator';
    import Alert from './Alert.svelte';
    import {updateCarModels} from '../store/cars';
    import {createNotification} from '../store/notifications';

    let error = '';
    let errorType = '';

    let make = '';
    let model = '';
    let bodyType = '';
    let numberOfSeats = '';
    let power = '';
    let transmission = '';

    const submit = async () => {
        const formData = new FormData();
        formData.append('make', make);
        formData.append('model', model);
        formData.append('body_type', bodyType);
        formData.append('number_of_seats', numberOfSeats);
        formData.append('power', power);
        formData.append('transmission', transmission);
        const res = await fetch('/api/cars/add_car_model.php', {
            method: 'POST',
            body: formData
        })
        const text = await res.text();
        errorType = res.status === 201 ? '' : 'error';
        error = res.status === 201 ? '' : text;
        if (res.status === 201) {
            createNotification('Added new car model', 'success');
            updateCarModels();
            // navigate('/admin/car-models')
        }
    }
</script>


<div class="car-models-add mx-0 max-h-full overflow-hidden flex flex-col">
    <h2 class="text-left m-2 text-xl font-bold text-gray-700 px-2">
        Add car model
    </h2>
    <form on:submit|preventDefault={() => {submit()}}
          class="block bg-white rounded-lg shadow-lg mx-2 my-3 mb-4 p-4 px-5 flex flex-row justify-between flex-wrap">
        <div class="float-left w-80">
            <h3 class="text-3xl mb-5 mt-1 font-bold text-gray-900">Add car model</h3>
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
                <img src={placeholderImage} alt="Add image"
                     class="h-60 rounded-lg mb-2 float-right"/>
            </div>
            <div class="block float-right">
                <button class="button mx-2 float-right" on:click|preventDefault={() => {submit()}}>
                    Add <span class="material-icons top-0.5 relative float-right ml-3">check</span>
                </button>
                <button class="button mx-2 float-right ml-4" on:click|preventDefault={() => navigate('/admin/car-models')}>
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
