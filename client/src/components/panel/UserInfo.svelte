<script>

import {user} from '../../store/user';
import {userReservations} from '../../store/userReservations';
</script>

<div class="bg-white shadow-lg p-4 mb-4 rounded-lg h-60 mt-4 mx-2">
    <h2 class="text-2xl font-bold text-gray-900">{$user.firstName} {$user.lastName}</h2>
    <span class="block my-2 text-gray-700 text-lg">{$user.email}</span>
    <span class="block my-1 mt-4 text-gray-700 text-lg">
        Waiting reservations: {$userReservations.filter(r => r.status === 'WAITING').length}
    </span>
    <span class="block my-1 text-gray-700 text-lg">
        Confirmed reservations: {$userReservations.filter(r => r.status === 'CONFIRMED').length}
    </span>
    <span class="block my-1 text-gray-700 text-lg">
        Active reservations: {$userReservations.filter(r => r.status === 'ACTIVE').length}
    </span>
    <span class="block my-1 text-gray-700 text-lg">
        Archived reservations: {$userReservations.filter(r => r.status === 'DONE' || r.status === 'CANCELLED').length}
    </span>
</div>


<style lang="scss">

</style>
