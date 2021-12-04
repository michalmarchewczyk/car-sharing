<script>
    import Alert from '../components/Alert.svelte';
    import {loggedIn} from '../store/user';
    import {navigate} from 'svelte-navigator';

    $: if($loggedIn === true){
        navigate('/');
    }

    let firstName = '';
    let lastName = '';
    let email = '';
    let password = '';

    let error = '';
    let errorType = 'error';

    const submit = async () => {
        const formData = new FormData();
        formData.append('first_name', firstName);
        formData.append('last_name', lastName);
        formData.append('email', email);
        formData.append('password', password);
        const res = await fetch('/api/users/register.php', {
            method: "POST",
            body: formData
        })
        const text = await res.text();
        errorType = res.status === 200 || res.status === 201 ? 'success' : 'error';
        error = text;
    }
</script>

<svelte:head>
    <title>
        Register - Car Sharing
    </title>
</svelte:head>
<div class="m-auto">
    <h1 class="text-center m-6 text-3xl font-bold text-gray-700">
        Register
    </h1>
    <form on:submit|preventDefault={submit} class="shadow-lg h-auto w-96 p-6 rounded-xl bg-white pt-2 pb-2 mb-20">
        {#if error}
            <Alert type={errorType}>{error}</Alert>
        {/if}
        <label>
            <span>First name:</span>
            <input type="text" required maxlength="30" bind:value={firstName}/>
        </label>
        <label>
            <span>Last name:</span>
            <input type="text" required maxlength="60" bind:value={lastName}/>
        </label>
        <label>
            <span>Email:</span>
            <input type="email" required maxlength="120" bind:value={email}/>
        </label>
        <label>
            <span>Password:</span>
            <input type="password" required minlength="4" bind:value={password}/>
        </label>
        <input type="submit" value="Register"/>
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
