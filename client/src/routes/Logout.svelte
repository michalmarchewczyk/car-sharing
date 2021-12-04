<script>
    import Alert from '../components/Alert.svelte';
    import {updateUserData} from '../store/user';

    let email = '';
    let password = '';

    let error = '';
    let errorType = 'error';

    const logout = async () => {
        const res = await fetch('/api/users/logout.php')
        const text = await res.text();
        errorType = res.status === 200 ? 'success' : 'error';
        error = text;
        await updateUserData();
    }

    logout();

</script>

<svelte:head>
    <title>
        Logout - Car Sharing
    </title>
</svelte:head>
<div class="m-auto">
    <h1 class="text-center m-6 text-3xl font-bold text-gray-700">
        Logout
    </h1>
    <div class="shadow-lg h-auto w-96 p-6 rounded-xl bg-white pt-6 pb-2 mb-20">
        {#if error}
            <Alert type={errorType}>{error}</Alert>
        {/if}
        <a href="/login">Login again</a>
    </div>
</div>

<style lang="scss">
  a {
	@apply block bg-blue-700 text-white p-2 w-full rounded-md hover:bg-blue-800 cursor-pointer text-lg font-bold mb-4 mt-6;
  }
</style>
