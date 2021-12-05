import {get, writable} from 'svelte/store';
import {createNotification} from './notifications';
import {carModels} from './carModels';

export const cars = writable([]);

export const fetchCars = async () => {
    const res = await fetch('/api/cars/get_cars_list.php');
    if (res.status === 200) {
        let data = await res.json();
        data = data.reverse();
        data = data.map(car => ({
            id: car['id'],
            modelId: car['model_id'],
            make: car['make'],
            model: car['model'],
            bodyType: car['body_type'],
            numberOfSeats: car['number_of_seats'],
            power: car['power'],
            transmission: car['transmission'],
            year: car['year'],
            mileage: car['mileage'],
            color: car['color'],
            availability: car['availability'],
            price: car['price'],
        }));
        cars.set(data);
    } else {
        throw new Error(await res.text());
    }
}

export const deleteCar = async ({id}) => {
    const formData = new FormData();
    formData.append('id', id);
    const res = await fetch('/api/cars/delete_car.php', {
        method: 'POST',
        body: formData
    });
    if (res.status === 200) {
        createNotification(`Deleted car [id=${id}]`, 'success');
        cars.update(cars => {
            return cars.filter(car => car.id !== id);
        });
        return true;
    } else {
        createNotification(`Error: ${await res.text()}`, 'error');
        return false;
    }
}


export const addCar = async ({modelId, year, mileage, color, price}) => {
    const formData = new FormData();
    formData.append('model_id', modelId);
    formData.append('year', year);
    formData.append('mileage', mileage);
    formData.append('color', color);
    formData.append('price', price);
    const res = await fetch('/api/cars/add_car.php', {
        method: 'POST',
        body: formData
    })
    const text = await res.text();
    if (res.status === 201) {
        createNotification('Added new car', 'success');
        console.log(text);
        const carModel = get(carModels).find(model => model.id === modelId);
        cars.update(cars => {
            return [{
                ...carModel,
                id: text,
                modelId, year, mileage, color, availability: 'AVAILABLE', price
            }, ...cars];
        })
        return true;
    } else {
        createNotification('Error: ' + text, 'error')
        return false;
    }
}


export const editCar = async ({id, mileage, year, color, price}) => {
    const formData = new FormData();
    formData.append('id', id);
    formData.append('mileage', mileage);
    formData.append('year', year);
    formData.append('color', color);
    formData.append('price', price);
    const res = await fetch('/api/cars/edit_car.php', {
        method: 'POST',
        body: formData
    })
    const text = await res.text();
    if (res.status === 200) {
        createNotification('Edited car [id='+id+']', 'success');
        cars.update(cars => {
            return cars.map(car => {
                if(car.id === id){
                    return {...car, mileage, year, color, price};
                }else{
                    return car;
                }
            })
        })
        return true;
    }else{
        createNotification('Error: '+text, 'error');
        return false;
    }
}
