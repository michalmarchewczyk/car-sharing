import {get, writable} from 'svelte/store';
import {createNotification} from './notifications';
import {cars} from './cars';

export const reservations = writable([]);

export const fetchReservations = async () => {
    const res = await fetch('/api/reservations/get_reservations_list.php');
    if (res.status === 200) {
        let data = await res.json();
        data = data.reverse();
        data = data.map(reservation => ({
            id: reservation['id'],
            carId: reservation['car_id'],
            userId: reservation['user_id'],
            startTime: reservation['start_time'],
            endTime: reservation['end_time'],
            status: reservation['status'],
            firstName: reservation['first_name'],
            lastName: reservation['last_name'],
            car: get(cars).find(car => car.id === reservation['car_id']),
        }));
        reservations.set(data);
    } else {
        throw new Error(await res.text());
    }
}

export const changeReservationStatus = async ({id, status}) => {
    const formData = new FormData();
    formData.append('id', id);
    formData.append('status', status);
    const res = await fetch('/api/reservations/change_reservation_status.php', {
        method: 'POST',
        body: formData
    });
    if (res.status === 200) {
        reservations.update(reservations => {
            return reservations.map(reservation => {
                if(reservation.id === id){
                    return {...reservation, status}
                }else{
                    return reservation;
                }
            })
        });
        createNotification(`Changed reservation #${id} status to ${status}`, 'success');
        return true;
    } else {
        createNotification(`Error: ${await res.text()}`, 'error');
        return false;
    }
}

export const editReservation = async ({id, startTime, endTime}) => {
    const formData = new FormData();
    formData.append('id', id);
    formData.append('start_time', startTime.getTime());
    formData.append('end_time', endTime.getTime());
    const res = await fetch('/api/reservations/edit_reservation.php', {
        method: 'POST',
        body: formData
    })
    const text = await res.text();
    if (res.status === 200) {
        createNotification('Edited reservation #'+id, 'success');
        reservations.update(reservations => {
            return reservations.map(reservation => {
                if(reservation.id === id){
                    return {...reservation, startTime, endTime};
                }else{
                    return reservation;
                }
            })
        })
        return true;
    }else{
        createNotification('Error: '+text, 'error');
        return false;
    }
}
