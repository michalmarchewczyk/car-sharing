<script>
    import {loggedIn, user} from '../store/user';
    import {currentTimestamp} from '../store/time';

    $: date = new Date($currentTimestamp*1000).toLocaleString('pl-PL');
</script>

<nav class="shadow-lg w-full h-auto p-2 z-50 px-4 overflow-hidden">
    <a href="/" class="h1">Car Sharing</a>
    <a href="/about">About</a>
    {#if $loggedIn !== null}
        {#if $loggedIn === true}
            <a href="/panel">Panel</a>
            {#if $user.type === 'MODERATOR' || $user.type === 'ADMIN'}
                <a href="/mod">Moderator panel</a>
            {/if}
            {#if $user.type === 'ADMIN'}
                <a href="/admin">Admin panel</a>
            {/if}
            <div class="float-right">
                <span>{date}</span>
                <a href="/">{$user.firstName + ' ' + $user.lastName}</a>
                <a href="/logout">Logout</a>
            </div>
        {:else}
            <div class="float-right">
                <span>{date}</span>
                <a href="/login">Login</a>
                <a href="/register">Register</a>
            </div>
        {/if}
    {/if}

</nav>

<style lang="scss">
  nav {
	a {
	  @apply inline-block mx-3 text-gray-600 hover:text-gray-900 font-bold mb-2 float-left text-lg mt-1.5;
    }

    span {
	  @apply inline-block mx-3 text-gray-400 font-bold mb-2 float-left text-lg mt-1.5;
    }

	.h1 {
	  @apply text-blue-700 font-extrabold text-xl mt-1;
    }
  }
</style>
