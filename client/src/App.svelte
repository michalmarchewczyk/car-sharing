<script>
import Styles from './Styles.svelte';

import { Router, Route, links } from "svelte-navigator";
import Home from "./routes/Home.svelte";
import About from "./routes/About.svelte";
import Panel from "./routes/Panel.svelte";
import Header from './components/Header.svelte';
import Login from './routes/Login.svelte';
import Register from './routes/Register.svelte';
import {updateUserData} from './store/user';
import Logout from './routes/Logout.svelte';
import ModPanel from './routes/ModPanel.svelte';
import AdminPanel from './routes/AdminPanel.svelte';
import {onMount} from 'svelte';
import Notifications from './components/Notifications.svelte';
import CarModelsList from './components/admin/carModels/CarModelsList.svelte';
import UsersList from './components/admin/users/UsersList.svelte';
import CarModelsListItem from './components/admin/carModels/CarModelsListItem.svelte';
import AdminRoute from './routes/AdminRoute.svelte';

onMount(() => {
	updateUserData();
})

</script>

<Styles/>

<Router primary={false}>
	<div class="flex flex-col w-full h-full" use:links>
		<Header/>
		<main class="w-full flex flex-1 bg-gray-200 overflow-hidden">
			<Route path="/"><Home/></Route>
			<Route path="login"><Login/></Route>
			<Route path="register"><Register/></Route>
			<Route path="logout"><Logout/></Route>
			<Route path="about"><About/></Route>
			<Route path="panel/*">
				<Route path="/">
					<Panel />
				</Route>
			</Route>
			<Route path="mod/*">
				<Route path="/">
					<ModPanel />
				</Route>
			</Route>
			<Route path="admin/*">
				<AdminRoute/>
			</Route>
		</main>
	</div>
	<Notifications/>
</Router>

<style lang="scss">

</style>
