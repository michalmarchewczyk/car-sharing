<script>
    import TOS from '../assets/TOS.pdf';
    import PDFWorker from 'pdfjs-dist/build/pdf.worker.js';
    import pdfjsLib from 'pdfjs-dist';
    pdfjsLib.GlobalWorkerOptions.workerSrc = "build/"+PDFWorker;

    let url = "build/"+TOS;

    let pages = [];
    let canvases = [];

    const loadPdf = async () => {
        let pdf = await pdfjsLib.getDocument(url).promise;
        console.log('PDF loaded', pdf);
        pages = (new Array(pdf._pdfInfo.numPages)).fill(1);
        for(let i = 0; i < pdf._pdfInfo.numPages; i++){
            let page = await pdf.getPage(i+1);
            let viewport = page.getViewport({scale: 1.2});
            let canvas = canvases[i];
            let context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            let renderContext = {
                canvasContext: context,
                viewport: viewport
            };
            await page.render(renderContext).promise;
        }
    }

    loadPdf();

</script>

<svelte:head>
    <title>
        About - Car Sharing
    </title>
</svelte:head>
<div class="w-full h-full overflow-y-scroll">
    <div class="mx-auto w-full max-w-7xl p-8">
        <h1 class="text-3xl text-gray-900 font-bold mb-4">
            About
        </h1>
        <p class="text-xl text-gray-700 font-bold">
            Car Sharing is a service that let's you rent a car for a small price.
        </p>
        <h2 class="text-2xl text-gray-900 font-bold mt-8 mb-4">
            Terms of Service:
        </h2>
        <div class="border-2 border-gray-700 rounded-lg overflow-y-scroll w-full bg-gray-600 flex flex-col items-center h-screen py-8">
            {#each pages as page, index}
                <canvas bind:this={canvases[index]} class="m-4 rounded-md shadow-md"></canvas>
            {/each}
        </div>
    </div>
</div>

