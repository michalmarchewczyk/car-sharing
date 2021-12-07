<script>
    import {loggedIn, user} from '../store/user';
    import {navigate} from 'svelte-navigator';
    import {onMount} from 'svelte';
    import {fetchCars} from '../store/cars';
    import {fetchReservations} from '../store/reservations';
    import {fetchUsers} from '../store/users';

    $: if($loggedIn === false){
        navigate('/login');
    }

    $: if($loggedIn === true && $user.type !== 'MODERATOR' && $user.type !== 'ADMIN'){
        navigate('/');
    }

    export let scrollable = true;

    onMount(async () => {
        await fetchCars();
        await fetchUsers();
        await fetchReservations();
    });
</script>

<svelte:head>
    <title>
        Moderator panel - Car Sharing
    </title>
</svelte:head>
{#if $user.type === 'MODERATOR' || $user.type === 'ADMIN'}
    <div class="px-12 w-full flex flex-col h-full"
         class:overflow-y-scroll={scrollable}
         class:pb-8={scrollable}
    >
        <h1>Moderator Panel</h1>
        <div class="flex flex-row flex-wrap gap-12 flex-1 content-start justify-center"
             class:overflow-visible={scrollable}
             class:overflow-hidden={!scrollable}
        >
            <slot></slot>
        </div>

    </div>
{/if}


<style lang="scss">
  h1 {
	@apply text-3xl font-bold text-gray-800 border-b-2 border-gray-500 pb-4 w-full my-6;
  }
</style>
