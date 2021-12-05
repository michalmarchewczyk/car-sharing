import {get, writable} from 'svelte/store';
import {cars} from './cars';
import {createNotification} from './notifications';
import {user} from './user';


export const userReservations = writable([]);


export const fetchUserReservations = async () => {
    const res = await fetch('/api/reservations/get_user_reservations_list.php');
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
            car: get(cars).find(car => car.id === reservation['car_id']),
        }));
        userReservations.set(data);
    } else {
        throw new Error(await res.text());
    }
}

export const addReservation = async ({ carId, startTime, endTime}) => {
    const formData = new FormData();
    formData.append('car_id', carId);
    formData.append('start_time', startTime.getTime());
    formData.append('end_time', endTime.getTime());
    const res = await fetch('/api/reservations/add_reservation.php', {
        method: 'POST',
        body: formData
    })
    const text = await res.text();
    if (res.status === 201) {
        createNotification('Made reservation #'+text, 'success');
        userReservations.update(reservations => {
            return [{
                    id: text,
                    carId: carId,
                    userId: get(user).id,
                    startTime: startTime,
                    endTime: endTime,
                    status: 'WAITING',
                    car: get(cars).find(car => car.id === carId),
                }, ...reservations]
        })
        return true;
    }else{
        createNotification('Error: '+text, 'error');
        return false;
    }
}


export const cancelReservation = async ({id}) => {
    const formData = new FormData();
    formData.append('id', id);
    const res = await fetch('/api/reservations/cancel_reservation.php', {
        method: 'POST',
        body: formData
    })
    const text = await res.text();
    if (res.status === 200) {
        createNotification('Cancelled reservation #'+id, 'success');
        userReservations.update(reservations => {
            return reservations.map(reservation => {
                if(reservation.id === id){
                    return {...reservation, status: 'CANCELLED'}
                }else{
                    return reservation;
                }
            })
        });
        return true;
    }else{
        createNotification('Error: '+text, 'error');
        return false;
    }
}
