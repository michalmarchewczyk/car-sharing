<script>
    import {Route} from 'svelte-navigator';
    import AdminPanel from './AdminPanel.svelte';
    import CarModelsList from '../components/CarModelsList.svelte';
    import UsersList from '../components/UsersList.svelte';
    import CarModelsAdd from '../components/CarModelsAdd.svelte';
    import CarModelInfo from '../components/CarModelInfo.svelte';
    import CarModelsEdit from '../components/CarModelsEdit.svelte';
</script>

<Route path="car-models/*">
    <AdminPanel scrollable={false}>
        <CarModelsList/>
        <Route path="/">
            <div class="h-24 pt-24 flex-1 rounded-xl pb-0 max-w-3xl text-3xl font-bold text-gray-400 text-center " style="min-width: 20rem">
                Select car model to view
            </div>
        </Route>
        <Route path="add">
            <CarModelsAdd/>
        </Route>
        <Route path="edit/:id">
            <CarModelsEdit/>
        </Route>
        <Route path=":id" let:params>
            <CarModelInfo/>
        </Route>
    </AdminPanel>
</Route>
<Route path="users/*">
    <AdminPanel scrollable={false}>
        <UsersList/>
        <Route path="/">
            <div class="h-24 pt-24 flex-1 rounded-xl pb-0 max-w-3xl text-3xl font-bold text-gray-400 text-center " style="min-width: 20rem">
                Select user to view
            </div>
        </Route>
    </AdminPanel>
</Route>
<Route path="/">
    <AdminPanel>
        <UsersList/>
        <CarModelsList/>
    </AdminPanel>
</Route>
