<script>
    import {Route} from 'svelte-navigator';
    import Panel from './Panel.svelte';
    import UserInfo from '../components/panel/UserInfo.svelte';
    import UserReservations from '../components/panel/UserReservations.svelte';
    import PanelCarsList from '../components/panel/PanelCarsList.svelte';
    import PanelCarsFilter from '../components/panel/PanelCarsFilter.svelte';
</script>

<Route path="/*">
    <Panel>
        <Route path="">
            <div class="w-96 flex flex-col">
                <UserInfo/>
                <UserReservations/>
            </div>
            <div class="w-80 flex-grow flex-shrink-0 max-w-6xl">
                <PanelCarsList/>
            </div>
        </Route>
        <Route path="cars">
            <div class="w-96 flex flex-col">
                <PanelCarsFilter/>
            </div>
            <div class="w-80 flex-grow flex-shrink-0 max-w-6xl">
                <PanelCarsList/>
            </div>
        </Route>
    </Panel>
</Route>
