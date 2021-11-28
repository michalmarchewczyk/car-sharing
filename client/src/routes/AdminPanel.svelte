<script>
    import {loggedIn, user} from '../store/user';
    import {navigate} from 'svelte-navigator';
    import UsersList from '../components/UsersList.svelte';

    $: if($loggedIn === false){
        navigate('/login');
    }

    $: if($loggedIn === true && $user.type !== 'ADMIN'){
        navigate('/');
    }
</script>

<svelte:head>
    <title>
        Admin panel - Car Sharing
    </title>
</svelte:head>
{#if $user.type === 'ADMIN'}
    <div class="px-12 w-full">
        <h1>Admin Panel</h1>
        <div class="flex flex-row flex-wrap gap-12">
            <UsersList/>
        </div>

    </div>
{/if}

<style lang="scss">
    h1 {
      @apply text-3xl font-bold text-gray-800 border-b-2 border-gray-500 pb-4 w-full my-6;
    }
</style>
