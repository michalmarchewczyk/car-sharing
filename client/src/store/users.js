import {writable} from 'svelte/store';
import {createNotification} from './notifications';

export const users = writable([]);


export const fetchUsers = async () => {
    const res = await fetch('/api/users/get_users_list.php');
    if(res.status === 200){
        let data = await res.json();
        data = data.reverse();
        users.set(data.map(u => ({
            id: parseInt(u['id']),
            firstName: u['first_name'],
            lastName: u['last_name'],
            type: u['type'],
            email: u['email'],
        })));
    }else{
        throw new Error(await res.text());
    }
}

export const changeUserType = async ({userId, type}) => {
    const formData = new FormData();
    formData.append('type', type);
    formData.append('user_id', userId);
    const res = await fetch('/api/users/change_user_type.php', {
        method: 'POST',
        body: formData
    });
    if(res.status === 200){
        createNotification(`Changed user[id=${userId}] type to ${type}`, 'success')
    }else{
        createNotification(`Error: ${await res.text()}`, 'error')
    }
}
