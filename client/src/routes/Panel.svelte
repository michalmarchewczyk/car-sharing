<script>
    import {loggedIn} from '../store/user';
    import {navigate} from 'svelte-navigator';

    $: if($loggedIn === false){
        navigate('/login');
    }
</script>

<svelte:head>
    <title>
        Panel - Car Sharing
    </title>
</svelte:head>
{#if $loggedIn}
    <h1>
        Panel
    </h1>
{/if}
