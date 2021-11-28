<script>
import Toast from './Toast.svelte';
import {notifications} from '../store/notifications';
</script>


<div>
    {#each $notifications as notification}
        {#if notification.visible}
            <Toast type={notification.type}>{notification.msg}</Toast>
        {/if}
    {/each}
</div>

<style lang="scss">
    div {
      @apply w-96 h-full mx-auto top-0 fixed bg-none z-50 inset-x-0 pointer-events-none flex flex-col pb-4 justify-end;
    }
</style>
