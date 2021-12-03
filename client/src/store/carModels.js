import {writable} from 'svelte/store';
import {createNotification} from './notifications';

export const carModels = writable([]);

export const fetchCarModels = async () => {
    const res = await fetch('/api/cars/get_car_models_list.php');
    if (res.status === 200) {
        let data = await res.json();
        data = data.reverse();
        data = data.map(carModel => ({
            id: carModel['id'],
            make: carModel['make'],
            model: carModel['model'],
            bodyType: carModel['body_type'],
            numberOfSeats: carModel['number_of_seats'],
            power: carModel['power'],
            transmission: carModel['transmission'],
        }));
        carModels.set(data);
    } else {
        throw new Error(await res.text());
    }
}

export const deleteCarModel = async ({id}) => {
    const formData = new FormData();
    formData.append('id', id);
    const res = await fetch('/api/cars/delete_car_model.php', {
        method: 'POST',
        body: formData
    });
    if (res.status === 200) {
        createNotification(`Deleted car model [id=${id}]`, 'success');
        carModels.update(models => {
            return models.filter(carModel => carModel.id !== id);
        });
        return true;
    } else {
        createNotification(`Error: ${await res.text()}`, 'error');
        return false;
    }
}


export const addCarModel = async ({make, model, bodyType, numberOfSeats, power, transmission}) => {
    const formData = new FormData();
    formData.append('make', make);
    formData.append('model', model);
    formData.append('body_type', bodyType);
    formData.append('number_of_seats', numberOfSeats);
    formData.append('power', power);
    formData.append('transmission', transmission);
    const res = await fetch('/api/cars/add_car_model.php', {
        method: 'POST',
        body: formData
    })
    const text = await res.text();
    if (res.status === 201) {
        createNotification('Added new car model', 'success');
        carModels.update(models => {
            return [{
                id: text,
                make, model, bodyType, numberOfSeats, power, transmission
            }, ...models];
        })
    } else {
        createNotification('Error: ' + text, 'error')
    }
}


export const editCarModel = async ({id, make, model, bodyType, numberOfSeats, power, transmission}) => {
    const formData = new FormData();
    formData.append('id', id);
    formData.append('make', make);
    formData.append('model', model);
    formData.append('body_type', bodyType);
    formData.append('number_of_seats', numberOfSeats);
    formData.append('power', power);
    formData.append('transmission', transmission);
    const res = await fetch('/api/cars/edit_car_model.php', {
        method: 'POST',
        body: formData
    })
    const text = await res.text();
    if (res.status === 200) {
        createNotification('Edited car model [id='+id+']', 'success');
        carModels.update(models => {
            return models.map(carModel => {
                if(carModel.id === id){
                    return {id, make, model, bodyType, numberOfSeats, power, transmission};
                }else{
                    return carModel;
                }
            })
        })
        return true;
    }else{
        createNotification('Error: '+text, 'error');
        return false;
    }
}
