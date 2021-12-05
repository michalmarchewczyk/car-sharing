import {get, writable} from 'svelte/store';
import {cars} from './cars';

export const filter = writable({
    make: '',
    model: '',
    bodyType: '',
    numberOfSeats: '',
    powerMin: 0,
    powerMax: 1000,
    transmission: '',
    yearMin: 0,
    yearMax: 4000,
    mileageMin: 0,
    mileageMax: 1000000,
    color: '',
    availability: '',
    priceMin: 0,
    priceMax: 1000,
})
export const filterValues = writable({
    make: [],
    model: [],
    bodyType: [],
    numberOfSeats: [],
    powerMin: Infinity,
    powerMax: -Infinity,
    transmission: [],
    yearMin: Infinity,
    yearMax: -Infinity,
    mileageMin: Infinity,
    mileageMax: -Infinity,
    color: [],
    availability: [],
    priceMin: Infinity,
    priceMax: -Infinity,
})

export const resetFilters = async () => {
    console.log('RESET FILTERS');

    const values = get(filterValues);

    get(cars).forEach(car => {
        ['make', 'model', 'bodyType', 'numberOfSeats', 'transmission', 'color', 'availability'].forEach(key => {
            if(!values[key].includes(car[key])) {
                values[key].push(car[key]);
            }
        });
        ['power', 'year', 'mileage', 'price'].forEach(key => {
            values[key+'Min'] = Math.min(values[key+'Min'], parseFloat(car[key]));
            values[key+'Max'] = Math.max(values[key+'Max'], parseFloat(car[key]));
        });
    });

    filterValues.set(values);

    filter.set({
        make: '',
        model: '',
        bodyType: '',
        numberOfSeats: '',
        transmission: '',
        color: '',
        powerMin: values.powerMin,
        powerMax: values.powerMax,
        yearMin: values.yearMin,
        yearMax: values.yearMax,
        mileageMin: values.mileageMin,
        mileageMax: values.mileageMax,
        availability: 'AVAILABLE',
        priceMin: values.priceMin,
        priceMax: values.priceMax,
    })
}
