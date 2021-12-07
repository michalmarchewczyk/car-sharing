<script>
    import image from '../assets/images/home_illustration.png';
</script>

<svelte:head>
    <title>
        Home - Car Sharing
    </title>
</svelte:head>
<div class="w-full h-full bg-white absolute block">
    <div class="mx-auto max-w-7xl h-full flex flex-col justify-center">
        <div class="h-40 w-full z-20" style="margin-top: -8rem;">
            <h1 class="text-blue-600 ml-4 text-6xl font-bold z-20 block">
                Car Sharing
            </h1>
            <span class="block text-gray-900 ml-4 mt-8 text-4xl font-bold z-20">
                Rent a car for as low as 20 PLN / day
            </span>
            <a href="/register" class="block w-40 mt-16 ml-4 bg-blue-700 text-white p-3 px-4 rounded-md hover:bg-blue-800 cursor-pointer text-xl font-bold">
                Register <span class="material-icons top-1 relative float-right ml-4">arrow_forward</span>
            </a>
            <img src={image} alt="Car Sharing" class="absolute right-0 w-1/2 mr-8" style="z-index: -1; margin-top: -22%;"/>
        </div>
    </div>
    <svg class="block w-full h-full absolute top-0 left-0 opacity-50" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="2000" height="1200" preserveAspectRatio="none" viewBox="0 0 2000 1200">
        <g mask="url(&quot;#SvgjsMask1046&quot;)" fill="none">
            <rect width="2000" height="1200" x="0" y="0" fill="rgba(222, 231, 255, 1)"></rect>
            <path d="M0,802.825C148.785,830.684,293.856,737.03,417.995,650.413C538.891,566.059,636.25,452.608,695.432,317.593C754.03,183.91,760.202,37.742,750.385,-107.889C739.9,-263.433,732.003,-428.341,636.824,-551.811C539.61,-677.921,384,-742.867,229.924,-783.05C79.068,-822.393,-80.563,-827.299,-228.273,-777.427C-372.661,-728.676,-484.875,-621.784,-585.829,-507.623C-687.648,-392.483,-788.232,-268.594,-812.46,-116.814C-836.859,36.035,-813.858,205.952,-719.293,328.49C-629.612,444.7,-450.747,429.883,-328.203,510.694C-203.406,592.991,-146.935,775.313,0,802.825" fill="#c6d6ff"></path>
            <path d="M2000 1843.972C2121.45 1852.158 2236.801 1793.5439999999999 2337.453 1725.087 2436.281 1657.87 2530.193 1572.58 2566.467 1458.6970000000001 2601.248 1349.5 2562.493 1233.528 2528.926 1123.952 2499.524 1027.972 2433.042 954.528 2385.02 866.3779999999999 2321.044 748.944 2318.748 580.732 2199.749 519.716 2082.508 459.601 1937.126 521.992 1816.436 574.84 1705.407 623.458 1629.618 718.9069999999999 1545.52 806.191 1456.45 898.635 1313.2530000000002 972.4300000000001 1309.72 1100.753 1306.132 1231.086 1457.251 1306.184 1528.752 1415.212 1586.887 1503.859 1612.158 1610.142 1690.569 1681.484 1778.521 1761.5059999999999 1881.361 1835.975 2000 1843.972" fill="#f6f8ff"></path>
        </g>
        <defs>
            <mask id="SvgjsMask1046">
                <rect width="2000" height="1200" fill="#ffffff"></rect>
            </mask>
        </defs>
    </svg>
</div>
