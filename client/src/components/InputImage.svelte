<script>
    export let image;
    export let title;

    let images;
    let imageInput;
    let imageDragging = false;
    let imageFromUrl = null;

    $: {
        if(images?.[0]){
            image = imageInput?.files?.[0];
        }else if(imageFromUrl){
            image = imageFromUrl;
        }else{
            image = null;
        }
    }

    $: imageUrl = imageFromUrl ? URL.createObjectURL(imageFromUrl) : null;

    const dropFile = async (e) => {
        const files =[...e.dataTransfer.files].filter(i => i instanceof File);
        if(files[0]){
            imageFromUrl = files[0];
            return;
        }
    }
</script>

<label
        on:drop|preventDefault={(e) => dropFile(e)}
        on:dragover|preventDefault={() => imageDragging = true}
        on:dragleave|preventDefault={() => imageDragging = false}
        class="absolute top-0 left-0 w-full h-full border-2 border-gray-600 focus:border-blue-600 rounded-md my-1">
    {#if !image}
        <span class="text-3xl text-gray-800 font-bold opacity-40 text-center w-full pt-4 block">{title ?? ''}</span>
    {/if}
    <input type="file" accept="image/png, image/jpeg" bind:value={images} bind:this={imageInput}
           class="hidden"/>
</label>
