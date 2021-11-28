<script>
    import Alert from './Alert.svelte';
    import UsersListItem from './UsersListItem.svelte';

    let users = [];

    const fetchUsers = async () => {
        const res = await fetch('/api/users/get_users_list.php');
        if(res.status === 200){
            const data = await res.json();
            return data.map(u => ({
                id: u['id'],
                firstName: u['first_name'],
                lastName: u['last_name'],
                type: u['type'],
                email: u['email'],
            }));
        }else{
            throw new Error(await res.text());
        }
    }
</script>


<div class="users-list m-auto mx-0">
    <h2 class="text-left m-2 text-xl font-bold text-gray-700">
        Users list
    </h2>
    {#await fetchUsers()}
        <p class="text-center text-lg font-bold text-gray-400 my-8">Loading...</p>
    {:then users}
        {#each users as user}
            <UsersListItem user={user}/>
        {/each}
    {:catch error}
        <Alert type="error">{error}</Alert>
    {/await}
</div>


<style lang="scss">
    .users-list {
	    @apply h-auto flex-1 rounded-xl pt-2 pb-2 max-w-md;
    }
</style>
