import {writable} from 'svelte/store';
import {SERVER_URL} from '../config';

export const user = writable({});
export const loggedIn = writable(null);


export const updateUserData = async () => {
    const res = await fetch(`${SERVER_URL}/api/users/get_user_info.php`, {
        method: "GET",
        credentials: 'include',
    })
    if(res.status !== 200){
        loggedIn.set(false);
        user.set({});
        return;
    }
    const data = await res.json();
    loggedIn.set(true);
    user.set({
        id: data.id,
        firstName: data.first_name,
        lastName: data.last_name,
        type: data.type,
        email: data.email,
    });
}
