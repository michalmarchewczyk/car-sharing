<script>
    import {loggedIn, user} from '../store/user';

</script>

<nav class="shadow-lg w-full h-12 p-2 z-50 px-4">
    <h1 class="">Car Sharing</h1>
    <a href="/">Home</a>
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
                <a href="/">{$user.firstName + ' ' + $user.lastName}</a>
                <a href="/logout">Logout</a>
            </div>
        {:else}
            <div class="float-right">
                <a href="/login">Login</a>
                <a href="/register">Register</a>
            </div>
        {/if}
    {/if}

</nav>

<style lang="scss">
  nav {
	a {
	  @apply text-xl mx-4 text-gray-600 hover:text-gray-900 font-bold;
    }

	h1 {
	  @apply text-blue-700 text-xl font-bold float-left ml-2 mr-8;
    }
  }
</style>
