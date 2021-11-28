<script>
    import {loggedIn, user} from '../store/user';
    import {navigate} from 'svelte-navigator';

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
    <h1>
        Admin Panel
    </h1>
{/if}
