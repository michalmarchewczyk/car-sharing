<script>
    import {loggedIn, user} from '../store/user';
    import {navigate} from 'svelte-navigator';

    $: if($loggedIn === false){
        navigate('/login');
    }

    $: if($loggedIn === true && $user.type !== 'MODERATOR' && $user.type !== 'ADMIN'){
        navigate('/');
    }
</script>

<svelte:head>
    <title>
        Moderator panel - Car Sharing
    </title>
</svelte:head>
{#if $user.type === 'MODERATOR' || $user.type === 'ADMIN'}
    <h1>
        Moderator Panel
    </h1>
{/if}
