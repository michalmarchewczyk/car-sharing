import {writable} from 'svelte/store';
import {createNotification} from './notifications';


export const currentTimestamp = writable(new Date().getTime()/1000);
export const timeEvents = writable([]);

let interval = null;

export const initializeInterval = () => {
    if(interval) return;
    interval = setInterval(async () => {
        await fetchCurrentTimestamp();
    }, 1000);
}

const fetchCurrentTimestamp = async () => {
    try {
        const res = await fetch('/api/time/get_current_time.php');
        const data = await res.json();
        const timestamp = data.value;
        currentTimestamp.set(timestamp);
    }catch(e){
        createNotification('Error: '+e, 'error');
    }
}


export const fetchTimeEvents = async () => {
    try {
        const res = await fetch('/api/time/get_time_events.php');
        const data = await res.json();
        timeEvents.set(data);
    }catch(e){
        createNotification('Error: '+e, 'error');
    }
}

export const changeTimeEvents = async ({realTime, skipForward, skipBackward}) => {
    const formData = new FormData();
    formData.append('reset_timestamp', realTime);
    formData.append('skip_forward', skipForward);
    formData.append('skip_backward', skipBackward);
    try {
        const res = await fetch('/api/time/change_time_events.php',  {
            method: 'POST',
            body: formData
        });
        const data = await res.text();
        if(res.status === 200){
            createNotification('Updated time settings', 'success');
        }
        await fetchTimeEvents();
    }catch(e){
        createNotification('Error: '+e, 'error');
    }
}
