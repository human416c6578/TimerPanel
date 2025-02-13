<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="css/globals.css">
    <script>
        function load_js()
        {
            var head= document.getElementsByTagName('head')[0];
            var script= document.createElement('script');
            script.src= './dist/hlviewer19.min.js';
            head.appendChild(script);
        }
        load_js();
    </script>
    
</head>
<!-- NavBar -->
<nav class="bg-gray-900 dark:bg-gray-900 border-gray-200">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="" class="flex items-center">
            <img src="img/logo.png" class="h-8 mr-3" alt="LaLeagane" />
            <span class="self-center text-2xl font-semibold text-white dark:text-white whitespace-nowrap">Bhop Panel</span>
        </a>
        <div class="flex md:order-2">
            <button id="toggleSearchButton" type="button" class="md:hidden text-gray-400 dark:text-gray-400 hover:bg-gray-700 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-700 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 mr-1" >
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
                <span class="sr-only">Search</span>
            </button>
            <div class="relative hidden md:block">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                    <span class="sr-only">Search icon</span>
                </div>
                <input type="text" id="search-navbar" class="block w-full p-2 pl-10 text-sm border rounded-lg bg-gray-700 dark:bg-gray-700 border-gray-600 dark:border-gray-600 placeholder-gray-400 dark:placeholder-gray-400 text-white dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500" placeholder="Search player...">
                <ul id="searchList" class="absolute z-20 w-full right-0 bg-gray-900 rounded text-start text-lg text-white font-semibold">

                </ul>
            </div>

            <button id="toggleMenuButton" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm rounded-lg md:hidden focus:outline-none focus:ring-2 text-gray-400 dark:text-gray-400 hover:bg-gray-700 dark:hover:bg-gray-700 focus:ring-gray-600 dark:focus:ring-gray-600" aria-controls="navbar-search" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>

        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-menu">
            <div class="relative mt-3 md:hidden">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" id="search-navbar-mobile" class="block w-full p-2 pl-10 text-sm border rounded-lg bg-gray-700 dark:bg-gray-700 border-gray-600 dark:border-gray-600 placeholder-gray-400 dark:placeholder-gray-400 text-white dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500" placeholder="Search player...">
                <ul id="searchListMobile" class="absolute z-20 w-full right-0 bg-gray-900 rounded text-start text-lg text-white font-semibold">
                </ul>
            </div>
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border rounded-lg md:flex-row md:space-x-8 md:mt-0 md:border-0 bg-gray-800 dark:bg-gray-800 border-gray-700 dark:border-gray-700 md:bg-gray-900 md:dark:bg-gray-900">
                <li>
                    <a href="/panel" class="block py-2 pl-3 pr-4 rounded md:hover:bg-transparent md:p-0 text-white dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 hover:text-white dark:hover:text-white md:dark:hover:bg-transparent border-gray-700 dark:border-gray-700 md:hover:text-blue-700 md:dark:hover:text-blue-500" aria-current="page">Home</a>
                </li>
                <li>
                    <a href="records.php" class="block py-2 pl-3 pr-4 rounded md:hover:bg-transparent md:p-0 text-white dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 hover:text-white dark:hover:text-white md:dark:hover:bg-transparent border-gray-700 dark:border-gray-700 md:hover:text-blue-700 md:dark:hover:text-blue-500">Records</a>
                </li>
                <li>
					<a href="top.php" class="block py-2 pl-3 pr-4 rounded md:hover:bg-transparent md:p-0 text-white dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 hover:text-white dark:hover:text-white md:dark:hover:bg-transparent border-gray-700 dark:border-gray-700 md:hover:text-blue-700 md:dark:hover:text-blue-500">Top</a>
                </li>
                <li>
                    <a href="logs.php" class="block py-2 pl-3 pr-4 rounded md:hover:bg-transparent md:p-0 text-white dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 hover:text-white dark:hover:text-white md:dark:hover:bg-transparent border-gray-700 dark:border-gray-700 md:hover:text-blue-700 md:dark:hover:text-blue-500">Logs</a>
                </li>
                <li>
                    <a href="https://discord.gg/r8k5J3TASC" class="block py-2 pl-3 pr-4 rounded md:hover:bg-transparent md:p-0 text-white dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 hover:text-white dark:hover:text-white md:dark:hover:bg-transparent border-gray-700 dark:border-gray-700 md:hover:text-blue-700 md:dark:hover:text-blue-500">Discord</a>
                </li>
                <li>
                    <a href="https://laleagane.ro/forum/forums/bhop.43633/" class="block py-2 pl-3 pr-4 rounded md:hover:bg-transparent md:p-0 text-white dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 hover:text-white dark:hover:text-white md:dark:hover:bg-transparent border-gray-700 dark:border-gray-700 md:hover:text-blue-700 md:dark:hover:text-blue-500">Forum</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="relative flex min-h-screen flex-col overflow-hidden bg-gray-50 py-6 sm:py-12">
    <img src="img/beams.jpg" alt="" class="absolute left-1/2 top-1/2 max-w-none -translate-x-1/2 -translate-y-1/2" width="1308" />
    <div class="absolute inset-0 bg-[url(img/grid.svg)] bg-center [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
    <div class="relative flex min-h-screen overflow-hidden flex-col xl:flex-row items-center xl:items-start xl:justify-around justify-start space-y-8 xl:space-y-0">
        <div class="flex flex-col space-y-6 xl:w-2/12 w-10/12">
            <div class="relative flex flex-col items-center justify-center overflow-hidden rounded border-blue-800 border-2 h-2/6 py-6 px-6 z-10 space-y-6">
                <span class="self-center text-2xl font-bold text-black dark:text-black">Announcements</span>
                <div class="flex flex-col bg-gray-900 w-full py-2 px-4 rounded-lg space-y-2">
                    <a class="self-center m-2 py-1 px-2 font-bold text-xl bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% rounded">Panel is UP!</a>
                    <span class="self-center text-lg font-small text-white dark:text-white">21.09.2023</span>
                </div>

            </div>
            <div id="serversContainer" class="relative flex flex-col items-center justify-center overflow-hidden z-10 space-y-6">

            </div>
        </div>

        <div class="relative flex flex-col justify-center overflow-hidden bg-gradient-to-r from-blue-500 to-red-500 rounded h-2/6 xl:w-6/12 w-full py-6 xl:px-6 px-0 z-10">
            <span class="self-center text-2xl font-semibold text-white dark:text-white mb-6">Replay</span>
            <div class="not-prose relative rounded-xl overflow-hidden bg-slate-800 dark:bg-slate-800">
                <div class="absolute inset-0 [mask-image:linear-gradient(0deg,#fff,rgba(255,255,255,0.6))] bg-grid-slate-700/25 dark:bg-grid-slate-700/25 dark:[mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]" style="background-position: 10px 10px;"></div>
                <div class="relative rounded-xl overflow-auto no-scrollbar">
                    <div class="shadow-sm table-wrp block max-h-[600px] my-4">
						<!-- Player Here -->
						<div class="h-[600px]" id="hlv-target"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="relative flex flex-col items-center justify-center overflow-hidden bg-gray-900 dark:bg-gray-900 rounded xl:w-2/12 w-10/12 py-6 px-6 z-10">
            <!-- Right column -->
        	<button id="downloadBtn" class="self-center m-2 py-1 px-4 font-semibold text-md text-white bg-red-500 rounded hover:bg-white hover:text-red-500 transition-colors duration-300">Download</button>    
	</div>
        </div>
    </div>



</div>

<!-- Footer -->
<footer class="bg-slate-900 rounded-lg shadow dark:bg-slate-900">
    <div class="flex flex-col w-full max-w-screen-xl mx-auto p-2 md:py-4">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="/panel" class="flex items-center mb-4 sm:mb-0">
                <img src="img/logo.png" class="h-8 mr-3" alt="Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Bhop Panel</span>
            </a>
            <ul class="flex flex-wrap items-center mb-2 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                <li>
                    <a href="/panel" class="mr-4 hover:underline md:mr-6 ">Home</a>
                </li>
                <li>
                    <a href="https://laleagane.ro/forum/forums/bhop.43633/" class="mr-4 hover:underline md:mr-6">Forum</a>
                </li>
                <li>
                    <a href="https://discord.gg/r8k5J3TASC" class="mr-4 hover:underline md:mr-6 ">Discord</a>
                </li>
                <li>
                    <a href="/records.php" class="hover:underline">Records</a>
                </li>
            </ul>
        </div>
        <hr class="my-2 border-gray-700  dark:border-gray-700" />
        <div class="flex flex-wrap justify-center space-x-4 space-y-1">
            <div class="flex flex-row items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-white mx-2 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </svg>
                <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">human416c6578@gmail.com</span>
            </div>
            <div class="flex flex-row items-center">
                <img class="mx-2 w-6" src="img/misc/discord.png"/>
                <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">@MrShark45</span>
            </div>

            <div class="flex flex-row items-center">
                <img class="mx-2 w-6" src="img/misc/steam.png"/>
                <a href="https://steamcommunity.com/id/mrshark45" class="block text-sm text-gray-500 sm:text-center dark:text-gray-400 hover:underline">MrShark45</a>
            </div>

        </div>


    </div>
</footer>
</html>

<script>
    window.addEventListener('load', async () => {
        // Initialize variables
        let mapName = '';
        let categoryName = '';

        // Function to fetch data from the server
        const fetchData = async (url, data) => {
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                });
                return await response.json();
            } catch (error) {
                console.error('Fetch error:', error);
            }
        };

        // Setters for map and category names
        const setMapName = (name) => {
            mapName = name;
        };

        const setCategoryName = (name) => {
            categoryName = name;
        };

        // Fetch map and category data
        const fetchMap = async (id) => {
            const map = await fetchData('api/get_map.php', { id });
            if (map) setMapName(map);
        };

        const fetchCategory = async (id) => {
            const category = await fetchData('api/get_category.php', { id });
            if (category) setCategoryName(category);
        };

        // Get URL parameters
        const { mapId, category } = getUrlParams();

        // Define URLs
        const urlBhop = "http://nostalgia.neopanel.ro/fdbd8f4f-7e2e-4a02-93b2-d37b4c94836e/cstrike/";
        const urlDr = "http://nostalgia.neopanel.ro/d595f794-34d2-45b2-a961-779858c7350e/cstrike/";
        let resourceUrl = '';

        // Fetch map and category information
        await fetchMap(mapId);
        await fetchCategory(category);

        // Determine the resource URL based on the map name
        resourceUrl = mapName.includes("deathrun") ? urlDr : urlBhop;

        // Define resource paths
        const paths = {
            base: `get_resources.php?url=${resourceUrl}`,
            replays: '../uploads/recording',
            maps: `get_resources.php?url=${resourceUrl}maps`,
            wads: `get_resources.php?url=${resourceUrl}`,
            skies: `get_resources.php?url=${resourceUrl}gfx/env`,
            sounds: `get_resources.php?url=${resourceUrl}sound`,
        };

        // Initialize and load the viewer
        const viewer = HLViewer.init('#hlv-target', { paths });
        await viewer.load(`${mapName}.bsp`);
        await viewer.load(`${mapName}/[${categoryName}].rec`);

	document.getElementById("downloadBtn").addEventListener("click", () => {
    		// Create a link element
   		 const link = document.createElement("a");

    		// Construct the file URL
    		const fileURL = `https://cs-gfx.eu/uploads/recording/${mapName}/[${categoryName}].rec`;

    		// Configure the link
    		link.href = fileURL;
    		link.download = `${mapName} - [${categoryName}].rec`; // The file name for the download

    		// Trigger the download
    		link.click();

    		// Optionally remove the link element after triggering the download
    		link.remove();
	});
});	

    // Utility function to get URL parameters
    function getUrlParams() {
        return Object.fromEntries(new URLSearchParams(window.location.search).entries());
    }
</script>



<script src="js/search-player.js"></script>
