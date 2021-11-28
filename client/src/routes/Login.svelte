<script>
    import {SERVER_URL} from '../config';
    import Alert from '../components/Alert.svelte';
    import {loggedIn, updateUserData} from '../store/user';
    import {navigate} from 'svelte-navigator';

    $: if($loggedIn === true){
        navigate('/');
    }

    let email = '';
    let password = '';

    let error = '';
    let errorType = 'error';

    const submit = async () => {
        const formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);
        const res = await fetch(`${SERVER_URL}/api/users/login.php`, {
            method: "POST",
            credentials: 'include',
            body: formData
        })
        const text = await res.text();
        errorType = res.status === 200 ? 'success' : 'error';
        error = text;
        await updateUserData();
        if(res.status === 200){
            navigate('/panel');
        }
    }
</script>

<svelte:head>
    <title>
        Login - Car Sharing
    </title>
</svelte:head>
<div class="m-auto">
    <h1 class="text-center m-6 text-3xl font-bold text-gray-700">
        Login
    </h1>
    <form on:submit|preventDefault={submit} class="shadow-lg h-auto w-96 p-6 rounded-xl bg-white pt-4 pb-2">
        {#if error}
            <Alert type={errorType}>{error}</Alert>
        {/if}
        <label>
            <span>Email:</span>
            <input type="email" required bind:value={email}/>
        </label>
        <label>
            <span>Password:</span>
            <input type="password" required bind:value={password}/>
        </label>
        <input type="submit" value="Login"/>
    </form>
</div>

<style lang="scss">
  label {
	@apply my-4 block;
	span {
	  @apply w-full text-lg text-gray-900 font-bold;
	}
	input {
	  @apply w-full border-2 border-gray-600 focus:border-blue-600 h-10 rounded-md my-1 text-lg;
	  text-indent: 0.5rem;
	}
  }
  input[type=submit] {
	@apply bg-blue-700 text-white p-2 w-full rounded-md hover:bg-blue-800 cursor-pointer text-lg font-bold my-4;
  }
</style>
