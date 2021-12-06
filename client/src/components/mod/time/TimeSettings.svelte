<script>
    import {changeTimeEvents, currentTimestamp, fetchTimeEvents, timeEvents} from '../../../store/time';
    import {onMount} from 'svelte';

    $: date = new Date($currentTimestamp*1000).toLocaleString('pl-PL');

    let realTime = false;
    let skipForward = false;
    let skipBackward = false;

    let initialized = false;

    $: {
        if(!initialized && $timeEvents.length > 1){
            initialized = true;
            realTime = $timeEvents.find(e => e.Name === 'reset_timestamp').Status === 'ENABLED';
            skipForward = $timeEvents.find(e => e.Name === 'skip_forward').Status === 'ENABLED';
            skipBackward = $timeEvents.find(e => e.Name === 'skip_backward').Status === 'ENABLED';
        }
    }

    onMount(async () => {
        await fetchTimeEvents();
    })

    const change = async () => {
        await changeTimeEvents({realTime, skipForward, skipBackward});

    }
</script>



<div class="time-settings mx-0 max-h-full overflow-hidden flex flex-col">
    <h2 class="text-left m-2 text-xl font-bold text-gray-700 px-2">
        Time settings
    </h2>
    <div class="flex-1 px-2 pb-2 w-full mt-2">
        <div class="shadow-lg bg-white rounded-lg my-3 p-4 w-full w-full h-16">
            <span class="text-xl font-bold text-gray-900">Current time:</span>
            <span class="text-xl font-bold text-gray-900 float-right text-right">{date}</span>
        </div>
        <div class="shadow-lg bg-white rounded-lg my-3 p-4 w-full w-full h-16">
            <span class="text-xl font-bold text-gray-900">Real time (update every 1s):</span>
            <input type="checkbox" bind:checked={realTime} on:change={change}/>
        </div>
        <div class="shadow-lg bg-white rounded-lg my-3 p-4 w-full w-full h-16">
            <span class="text-xl font-bold text-gray-900">Skip forward (+1 day / 5s):</span>
            <input type="checkbox" bind:checked={skipForward} on:change={change}/>
        </div>
        <div class="shadow-lg bg-white rounded-lg my-3 p-4 w-full w-full h-16">
            <span class="text-xl font-bold text-gray-900">Skip backward (-1 day / 5s):</span>
            <input type="checkbox" bind:checked={skipBackward} on:change={change}/>
        </div>
    </div>
</div>


<style lang="scss">
  .time-settings {
	@apply h-auto flex-1 rounded-xl pt-2 pb-0 max-w-md;
	min-width: 20rem;
  }

  input {
    @apply block w-6 h-6 border-gray-700 border-2 rounded-md float-right mt-1.5 mr-2 cursor-pointer;
  }
</style>
