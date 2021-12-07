<script>
    import {createNotification} from '../../../store/notifications';
    import {changeUserType} from '../../../store/users';

    export let user = {};

    $: isAdmin = user.type === 'ADMIN';
    $: disabled = isAdmin;

    const changeType = async () => {
        await changeUserType({userId: user.id, type: user.type});

    }
</script>

<div class="users-list-item">
    <div class="w-24 flex-grow">
        <span class="users-list-item-name overflow-ellipsis overflow-hidden">{user.firstName} {user.lastName}</span>
        <span class="users-list-item-id overflow-ellipsis overflow-hidden">
            <span class="text-gray-400 text-base font-normal">[id={user.id}]</span>
            {user.email}
        </span>
    </div>
    <div class="w-32 ml-4">
        <select bind:value={user.type} {disabled} on:change={changeType}>
            <option value="WAITING" disabled>WAITING</option>
            <option value="CUSTOMER">CUSTOMER</option>
            <option value="MODERATOR">MODERATOR</option>
            <option value="BANNED">BANNED</option>
            {#if isAdmin}
                <option value="ADMIN">ADMIN</option>
            {/if}
        </select>
    </div>
</div>

<style lang="scss">
    .users-list-item {
      @apply shadow-lg bg-white rounded-lg my-3 p-2 px-4 flex flex-row w-full;

      div > span {
        @apply block flex-1 whitespace-nowrap;
        &.users-list-item-name {
          @apply text-lg font-bold text-gray-800;

        }
        &.users-list-item-id {
		  @apply text-base text-gray-700;
        }
	  }
      div {
        select{
          @apply bg-white w-full border-2 border-gray-600 focus:border-blue-600 h-10 rounded-md text-base my-2 disabled:opacity-50 px-1;
		}
	  }
    }

</style>
