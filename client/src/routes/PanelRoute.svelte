<script>
    import {Route} from 'svelte-navigator';
    import Panel from './Panel.svelte';
    import UserInfo from '../components/panel/UserInfo.svelte';
    import UserReservations from '../components/panel/UserReservations.svelte';
    import PanelCarsList from '../components/panel/PanelCarsList.svelte';
    import PanelCarsFilter from '../components/panel/PanelCarsFilter.svelte';
    import PanelReservation from '../components/panel/PanelReservation.svelte';
    import UserReservationInfo from '../components/panel/UserReservationInfo.svelte';
</script>

<Route path="/*">
<!--    <Panel>-->
        <Route path="">
            <Panel>
                <div class="w-96 flex flex-col">
                    <UserInfo/>
                    <UserReservations/>
                </div>
                <div class="w-80 flex-grow flex-shrink-0 max-w-6xl">
                    <PanelCarsList/>
                </div>
            </Panel>
        </Route>
        <Route path="cars">
            <Panel>
                <div class="w-96 flex flex-col">
                    <PanelCarsFilter/>
                </div>
                <div class="w-80 flex-grow flex-shrink-0 max-w-6xl">
                    <PanelCarsList/>
                </div>
            </Panel>
        </Route>
        <Route path="make-reservation/:id">
            <Panel>
                <div class="w-96 flex-grow max-w-4xl">
                    <PanelReservation/>
                </div>
            </Panel>
        </Route>
        <Route path="reservations/*">
            <Panel scrollable={false}>
                <UserReservations/>
                <Route path="/">
                    <div class="h-24 pt-24 flex-1 rounded-xl pb-0 max-w-3xl text-3xl font-bold text-gray-400 text-center " style="min-width: 20rem">
                        Select reservation to view
                    </div>
                </Route>
                <Route path=":id" let:params>
                    <UserReservationInfo/>
                </Route>
            </Panel>
        </Route>
<!--    </Panel>-->
</Route>
