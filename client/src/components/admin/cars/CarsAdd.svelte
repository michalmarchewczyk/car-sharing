<script>
    import placeholderImage from '../../../assets/images/car_placeholder.png';
    import {navigate, useLocation} from 'svelte-navigator';
    import {addCar} from '../../../store/cars';

    const location = useLocation();

    let modelId = $location.state.modelId ?? '';
    let year = '';
    let mileage = '';
    let color = '';
    let price = 0;

    const submit = async () => {
        const added = await addCar({modelId: parseInt(modelId), year, mileage, color, price});
        if(added){
            navigate('/admin/cars');
        }
    }


    $: fetchImage = async () => {
        if(!modelId) throw new Error('No id');
        const res = await fetch('/data/photos/car_models/'+modelId+'.jpg');
        if(res.status === 200){
            const data = await res.blob();
            return URL.createObjectURL(data);
        }else{
            throw new Error(await res.text());
        }
    }

</script>


<div class="car-models-add mx-0 max-h-full overflow-hidden flex flex-col">
    <h2 class="text-left m-2 text-xl font-bold text-gray-700 px-2">
        Add car
    </h2>
    <form on:submit|preventDefault={() => {submit()}}
          class="block bg-white rounded-lg shadow-lg mx-2 my-3 mb-4 p-4 px-5 flex flex-row justify-between flex-wrap">
        <div class="float-left w-80">
            <h3 class="text-3xl mb-5 mt-1 font-bold text-gray-900">Add car</h3>
            <label>
                <span>Model id: </span>
                <input type="text" bind:value={modelId} required/>
            </label>
            <label>
                <span>Year: </span>
                <input type="number" bind:value={year} required/>
            </label>
            <label>
                <span>Mileage: </span>
                <input type="number" bind:value={mileage} required/>
            </label>
            <label>
                <span>Color: </span>
                <input type="text" bind:value={color} required/>
            </label>
            <label>
                <span>Price: </span>
                <input type="number" bind:value={price} required/>
            </label>
        </div>
        <div class="ml-12 flex-1 flex-shrink-0" style="min-width: 16rem">
            <div class="block h-80 mb-8 flex justify-center items-center relative">
                {#await fetchImage()}
                    <img src={placeholderImage} alt=""
                         class="h-60 rounded-lg mb-2 float-right"/>
                {:then image}
                    <div class="h-60 w-full max-w-sm mb-4 mt-4 relative flex justify-center items-center float-right">
                        <img src={image} alt="" class="rounded-lg"/>
                    </div>
                {:catch error}
                    <img src={placeholderImage} alt=""
                         class="h-60 rounded-lg mb-2 float-right"/>
                {/await}
            </div>
            <div class="block float-right">
                <button class="button mx-2 float-right" on:click|preventDefault={() => {submit()}}>
                    Add <span class="material-icons top-0.5 relative float-right ml-3">check</span>
                </button>
                <button class="button mx-2 float-right ml-4" on:click|preventDefault={() => navigate('/admin/cars')}>
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

	form > div > label > span {
	  @apply text-xl text-gray-800 my-1 mr-4 whitespace-nowrap flex-shrink-0 flex-grow-0 font-bold;
	}

	input:not([type='file']) {
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
