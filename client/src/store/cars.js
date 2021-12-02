import {writable} from 'svelte/store';


export const latestCarModelsUpdate = writable(new Date());


export const updateCarModels = () => {
    latestCarModelsUpdate.set(new Date());
}
