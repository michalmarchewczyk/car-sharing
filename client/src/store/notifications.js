import {writable} from 'svelte/store';

export const notifications = writable([]);


export const createNotification = (msg, type) => {
    const notification = {msg, type, visible:true}
    notifications.update(v => [...v, notification]);
    setTimeout(() => {
        notification.visible = false;
        notifications.update(v => v);
    }, 6000)
}
