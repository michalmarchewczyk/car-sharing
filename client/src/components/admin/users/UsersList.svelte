<script>
    import UsersListItem from './UsersListItem.svelte';
    import {useLocation} from 'svelte-navigator';
    import {users} from '../../../store/users';

    const location = useLocation();

</script>


<div class="users-list mx-0 max-h-full overflow-hidden flex flex-col">
    <h2 class="text-left m-2 text-xl font-bold text-gray-700 px-2">
        Users list
        {#if $location.pathname === '/admin'}
            <a href='/admin/users' class="button">
                View all <span class="material-icons top-0 relative float-right ml-1">arrow_forward</span>
            </a>
        {/if}
    </h2>
    <div class="overflow-y-auto flex-1 px-2 pb-2">
        {#each ($location.pathname === '/admin' ? $users.slice(0,6) : $users) as user}
            <UsersListItem user={user}/>
        {:else}
            <p class="text-center text-lg font-bold text-gray-400 my-8">Loading...</p>
        {/each}
    </div>
</div>


<style lang="scss">
    .users-list {
      @apply h-auto flex-1 rounded-xl pt-2 pb-0 max-w-md;
      min-width: 20rem;
    }
	.button {
	  @apply inline-block relative mx-3 bg-blue-700 text-white p-1.5 px-2 rounded-md hover:bg-blue-800 cursor-pointer text-base font-bold;
	}
</style>
