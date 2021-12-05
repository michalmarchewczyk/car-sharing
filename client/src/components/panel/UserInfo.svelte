<script>

import {user} from '../../store/user';
</script>

<div class="bg-white shadow-lg p-4 mb-4 rounded-lg h-52 mt-4">
    <h2 class="text-2xl font-bold text-gray-900">{$user.firstName} {$user.lastName}</h2>
    <span class="block my-2 text-gray-700 text-lg">{$user.email}</span>
    <span class="block my-1 mt-4 text-gray-700 text-lg">Waiting reservations: 0</span>
    <span class="block my-1 text-gray-700 text-lg">Confirmed reservations: 0</span>
    <span class="block my-1 text-gray-700 text-lg">Archived reservations: 0</span>
</div>


<style lang="scss">

</style>
