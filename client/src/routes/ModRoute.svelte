<script>
    import {Route} from 'svelte-navigator';
    import ModPanel from './ModPanel.svelte';
    import ReservationsList from '../components/mod/reservations/ReservationsList.svelte';
    import ReservationInfo from '../components/mod/reservations/ReservationInfo.svelte';
    import ReservationsEdit from '../components/mod/reservations/ReservationsEdit.svelte';
    import TimeSettings from '../components/mod/time/TimeSettings.svelte';
</script>

<Route path="reservations/*">
    <ModPanel scrollable={false}>
        <ReservationsList/>
        <Route path="/">
            <div class="h-24 pt-24 flex-1 rounded-xl pb-0 max-w-3xl text-3xl font-bold text-gray-400 text-center " style="min-width: 20rem">
                Select reservation to view
            </div>
        </Route>
        <Route path="/edit/:id" let:params>
            <ReservationsEdit/>
        </Route>
        <Route path=":id" let:params>
            <ReservationInfo/>
        </Route>
    </ModPanel>
</Route>
<Route path="/">
    <ModPanel>
        <ReservationsList/>
        <TimeSettings/>
    </ModPanel>
</Route>
