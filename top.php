<?php
require_once "api/db.php"; // Include the file with the db class
$db = new api\db();

$cups = ["gold_cup", "silver_cup", "bronze_cup"];

$records = $db->get_latest_records();

$records = json_decode($records, true);
$maps = json_decode($db->get_maps(), true);

?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="css/globals.css">
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
                    <a href="top.php" class="block py-2 pl-3 pr-4 rounded md:bg-transparent md:p-0 text-white bg-blue-700 md:text-blue-700 md:dark:text-blue-500">Top</a>
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
<!-- Body -->
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
            <span class="self-center text-2xl font-semibold text-white dark:text-white mb-6">Top</span>
            <div class="not-prose relative rounded-xl overflow-hidden bg-slate-800 dark:bg-slate-800">
                <div class="absolute inset-0 [mask-image:linear-gradient(0deg,#fff,rgba(255,255,255,0.6))] bg-grid-slate-700/25 dark:bg-grid-slate-700/25 dark:[mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]" style="background-position: 10px 10px;"></div>
                <div class="relative rounded-xl overflow-auto no-scrollbar">
                    <div class="shadow-sm table-wrp block max-h-[600px] my-4">
                        <table class="category-table border-collapse table-fixed xl:table-auto w-full text-sm ">
                            <thead class="py-4 bg-slate-800 dark:bg-slate-800 sticky top-0">
                            <tr>
                                <th class="w-12 overflow-hidden border-b border-slate-600 dark:border-slate-600  xl:text-sm text-xs xl:text-medium p-4 pr-4 pt-2 pb-3 text-slate-200 dark:text-slate-200 text-left">Rank</th>
                                <th class="w-1/4 overflow-hidden border-b border-slate-600 dark:border-slate-600 text-xs xl:text-sm p-4 pr-4 pt-2 pb-3 text-slate-200 dark:text-slate-200 text-left">Name</th>
                                <th class="border-b border-slate-600 dark:border-slate-600 xl:text-sm text-xs p-4 pr-4 pt-2 pb-3 text-slate-200 dark:text-slate-200 text-left">Score</th>
                                <th class="border-b border-slate-600 dark:border-slate-600 xl:text-sm text-xs p-4 pr-4 pt-2 pb-3 text-slate-200 dark:text-slate-200 text-left">Bronze</th>
                                <th class="border-b border-slate-600 dark:border-slate-600 xl:text-sm text-xs p-4 pr-4 pt-2 pb-3 text-slate-200 dark:text-slate-200 text-left">Silver</th>
                                <th class="border-b border-slate-600 dark:border-slate-600 xl:text-sm text-xs p-4 pr-4 pt-2 pb-3 text-slate-200 dark:text-slate-200 text-left">Gold</th>

                            </tr>
                            </thead>

                            <tbody id="top-body" class="h-96 overflow-y-auto">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="relative flex flex-col items-center justify-center overflow-hidden bg-gray-900 dark:bg-gray-900 rounded xl:w-2/12 w-10/12 py-6 px-6 z-10">
            <span class="self-center text-2xl font-semibold text-white dark:text-white">Maps</span>
            <div class="relative mt-3">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" id="mapSearch" class="block w-full p-2 pl-10 text-sm border rounded-lg bg-gray-700 dark:bg-gray-700 border-gray-600 dark:border-gray-600 placeholder-gray-400 dark:placeholder-gray-400 text-white dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500" placeholder="Search map...">
            </div>
            <ul class="text-lg text-center font-semibold text-white dark:text-white space-y-2 mt-4" id="mapList">
                <?php foreach ($maps as $map): ?>
                    <li class="map-item hidden"><a href="map.php?id=<?php echo $map["id"]?>" class="text-md hover:text-blue-800 duration-150"><?php echo $map["name"]; ?></a></li>
                <?php endforeach; ?>
            </ul>
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
    const serversContainer = document.getElementById("serversContainer");


    function createServerCard(server)
    {
        const div = document.createElement("div");
        div.className = "flex flex-col bg-slate-900 w-full rounded space-y-2 p-2";

        const span = document.createElement("span");
        span.className =
            "self-center py-1 px-2 font-bold text-base bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% rounded";
        span.textContent = server.HostName.slice(0, 51);

        const innerDiv = document.createElement("div");
        innerDiv.className = "flex flex-col space-y-10";

        const innerFlexDiv = document.createElement("div");
        innerFlexDiv.className = "flex flex-row justify-between flex-wrap";

        const mapSpan = document.createElement("span");
        mapSpan.className =
            "self-center m-2 py-1 px-2 font-light text-md text-white rounded ring-1 ring-cyan-500";
        mapSpan.textContent = server.Map;

        const playerSpan = document.createElement("span");
        playerSpan.className =
            "self-center m-2 py-1 px-2 font-light text-md text-white rounded ring-1 ring-cyan-500";
        playerSpan.textContent = server.Players + "/" + server.MaxPlayers;

        const joinLink = document.createElement("a");
        joinLink.href = "steam://connect/" + server.Address;
        joinLink.className =
            "self-center m-2 py-1 px-2 font-semibold text-md hover:bg-clip-border hover:text-slate-950  text-white hover:bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% rounded ring-1 ring-cyan-500 duration-150 cursor-pointer";
        joinLink.textContent = "Join";

        // Build the structure
        innerFlexDiv.appendChild(mapSpan);
        innerFlexDiv.appendChild(playerSpan);
        innerFlexDiv.appendChild(joinLink);
        innerDiv.appendChild(innerFlexDiv);
        div.appendChild(span);
        div.appendChild(innerDiv);

        return div;
    }

    function fetchServers()
    {
        // URL to your PHP script
        const url = 'api/get_servers.php';


        // Send a POST request to the PHP script
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(servers => {
                servers.forEach(server => {
                    serversContainer.appendChild(createServerCard(server));
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    fetchServers();

</script>

<script>
    function populateTable(entries) {
        // Get a reference to the table body
        const tableBody = document.querySelector('#top-body');

        // Clear the table body
        tableBody.innerHTML = '';

        const tdClasses = 'border-b border-slate-700 dark:border-slate-700 p-4 pr-4 xl:text-sm text-xs xl:text-medium text-slate-400 dark:text-slate-400';
        const cups = ["gold_cup", "silver_cup", "bronze_cup"];
        let rank = 0;
        // Loop through the records array
        for(const entry of entries)
        {
            rank++;
            let row = document.createElement('tr');

            let rankCell = document.createElement('td');
            rankCell.className = tdClasses;

            if (rank < 4) {
                let img2 = document.createElement('img');
                img2.style.height = '18px';
                img2.src = `img/cups/${cups[rank - 1]}.png`;
                rankCell.appendChild(img2);
            } else {
                rankCell.textContent = rank.toString();
            }

            row.appendChild(rankCell);

            const nameCell = document.createElement('td');
            nameCell.className = tdClasses + " overflow-hidden";
            const divName = document.createElement("div");
            divName.className = "flex items-center text-center";
            const img = document.createElement('img');
            img.classList.add('w-6', 'mr-1');
            img.src = 'img/flags/' + entry.nationality.toLowerCase() + '.png';
            const nameLink = document.createElement('a');
            nameLink.className = 'hover:text-blue-500 duration-150 cursor-pointer';
            nameLink.href = "player.php?id=" + entry.id;
            nameLink.innerText = entry.name;
            divName.appendChild(img);
            divName.appendChild(nameLink);
            nameCell.appendChild(divName);
            row.appendChild(nameCell);

            let scoreCell = document.createElement('td');
            scoreCell.className = tdClasses;
            scoreCell.textContent = entry.score;
            row.appendChild(scoreCell);

            const bronzeCell = document.createElement('td');
            bronzeCell.className = tdClasses + " overflow-hidden";
            const divBronze = document.createElement("div");
            divBronze.className = "flex items-center text-center";
            const bronzeImg = document.createElement('img');
            bronzeImg.classList.add('w-6', 'ml-1');
            bronzeImg.src = 'img/medals/bronze.png';
            divBronze.innerText = entry.bronze.toString();
            divBronze.appendChild(bronzeImg);
            bronzeCell.appendChild(divBronze);
            row.appendChild(bronzeCell);

            const silverCell = document.createElement('td');
            silverCell.className = tdClasses + " overflow-hidden";
            const divSilver = document.createElement("div");
            divSilver.className = "flex items-center text-center";
            const silverImg = document.createElement('img');
            silverImg.classList.add('w-6', 'ml-1');
            silverImg.src = 'img/medals/silver.png';
            divSilver.innerText = entry.silver.toString();
            divSilver.appendChild(silverImg);
            silverCell.appendChild(divSilver);
            row.appendChild(silverCell);

            const goldCell = document.createElement('td');
            goldCell.className = tdClasses + " overflow-hidden";
            const divGold = document.createElement("div");
            divGold.className = "flex items-center text-center";
            const goldImg = document.createElement('img');
            goldImg.classList.add('w-6', 'ml-1');
            goldImg.src = 'img/medals/gold.png';
            divGold.innerText = entry.gold.toString();
            divGold.appendChild(goldImg);
            goldCell.appendChild(divGold);
            row.appendChild(goldCell);

            // Append the row to the table body
            tableBody.appendChild(row);
        }
    }

    function fetchRecords()
    {
        // URL to your PHP script
        const url = 'api/get_top.php';


        // Send a POST request to the PHP script
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(entries => {
                populateTable(entries);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    fetchRecords();


</script>

<script src="js/search-map.js"></script>
<script src="js/search-player.js"></script>
