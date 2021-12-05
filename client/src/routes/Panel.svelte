<script>
    import {loggedIn} from '../store/user';
    import {navigate} from 'svelte-navigator';
    import {onMount} from 'svelte';
    import {fetchCars} from '../store/cars';
    import {fetchReservations} from '../store/reservations';

    $: if($loggedIn === false){
        navigate('/login');
    }


    onMount(async () => {
        await fetchCars();
    });
</script>

<svelte:head>
    <title>
        Panel - Car Sharing
    </title>
</svelte:head>
{#if $loggedIn}
    <div class="px-12 w-full flex flex-col h-full overflow-y-scroll">
        <h1>Panel</h1>
        <div class="flex flex-row flex-wrap gap-12 flex-1 justify-center">
            <slot></slot>
        </div>
    </div>
{/if}

<style lang="scss">
  h1 {
	@apply text-3xl font-bold text-gray-800 border-b-2 border-gray-500 pb-4 w-full my-6;
  }
</style>
