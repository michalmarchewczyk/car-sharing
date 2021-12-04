<script>
    import {Route} from 'svelte-navigator';
    import AdminPanel from './AdminPanel.svelte';
    import CarModelsList from '../components/admin/carModels/CarModelsList.svelte';
    import UsersList from '../components/admin/users/UsersList.svelte';
    import CarModelsAdd from '../components/admin/carModels/CarModelsAdd.svelte';
    import CarModelInfo from '../components/admin/carModels/CarModelInfo.svelte';
    import CarModelsEdit from '../components/admin/carModels/CarModelsEdit.svelte';
    import CarsList from '../components/admin/cars/CarsList.svelte';
    import CarInfo from '../components/admin/cars/CarInfo.svelte';
    import CarsAdd from '../components/admin/cars/CarsAdd.svelte';
    import CarsEdit from '../components/admin/cars/CarsEdit.svelte';
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
<Route path="cars/*">
    <AdminPanel scrollable={false}>
        <CarsList/>
        <Route path="/">
            <div class="h-24 pt-24 flex-1 rounded-xl pb-0 max-w-3xl text-3xl font-bold text-gray-400 text-center " style="min-width: 20rem">
                Select car to view
            </div>
        </Route>
        <Route path="add">
            <CarsAdd/>
        </Route>
        <Route path="edit/:id">
            <CarsEdit/>
        </Route>
        <Route path=":id" let:params>
            <CarInfo/>
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
        <CarsList/>
    </AdminPanel>
</Route>
