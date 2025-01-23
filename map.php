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
        <a href="/panel" class="flex items-center">
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
                    <a href="/panel" class="block py-2 pl-3 pr-4 rounded md:hover:bg-transparent md:p-0 text-white dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 hover:text-white dark:hover:text-white md:dark:hover:bg-transparent border-gray-700 dark:border-gray-700 md:hover:text-blue-700 md:dark:hover:text-blue-500">Home</a>
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
<!-- Body -->
<div class="relative flex min-h-screen flex-col overflow-hidden bg-gray-50 py-6 sm:py-12">
    <img src="img/beams.jpg" alt="" class="absolute left-1/2 top-1/2 max-w-none -translate-x-1/2 -translate-y-1/2" width="1308" />
    <div class="absolute inset-0 bg-[url(img/grid.svg)] bg-center [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
    <div class="relative flex min-h-screen overflow-hidden flex-col xl:flex-row items-center xl:items-start xl:justify-around justify-start space-y-8 xl:space-y-0">
        <div class="relative flex flex-col justify-center overflow-hidden bg-gray-900 dark:bg-gray-900 rounded h-2/6 xl:w-2/12 w-10/12 py-6 px-6 z-10">
            <div id="button-container" class="flex flex-col space-y-2">
            </div>
        </div>
        <div class="relative flex flex-col justify-center overflow-hidden bg-gradient-to-r from-blue-500 to-red-500 rounded h-2/6 xl:w-6/12 w-full py-6 xl:px-6 px-0 z-10">
            <div class="flex flex-row justify-center">
                <span id="mapName" class="self-center text-2xl font-semibold text-white dark:text-white mb-6"></span>
            </div>

            <div class="not-prose relative rounded-xl overflow-hidden bg-slate-800 dark:bg-slate-800">
                <div class="absolute inset-0 [mask-image:linear-gradient(0deg,#fff,rgba(255,255,255,0.6))] bg-grid-slate-700/25 dark:bg-grid-slate-700/25 dark:[mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]" style="background-position: 10px 10px;"></div>
                <div class="relative rounded-xl overflow-auto no-scrollbar">
                    <div id="table-container" class="shadow-sm table-wrp block max-h-[600px] my-4">
                    </div>

                </div>

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
    function getUrlParams() {
        const searchParams = new URLSearchParams(window.location.search);
        const params = {};

        for (const [key, value] of searchParams.entries()) {
            params[key] = value;
        }

        return params;
    }

    const params = getUrlParams();
    
    let loggedin = false;
    function sendPostRequest(url, data, callback) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", url, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.setRequestHeader("Authorization", localStorage.getItem("token"));
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          callback(xhr.responseText);
        }
        else if (xhr.status === 403) {
            //
        }
      };
      xhr.send(data);
    }
    
    sendPostRequest("./api/login.php", ``, function (response) {
      // Handle the response from the PHP script here
      console.log(response);
      loggedin = true;
    });
    

    const buttonContainer = document.getElementById('button-container');
    const tableContainer = document.getElementById('table-container');
    const mapNameContainer = document.getElementById('mapName');
    let categoryNameGlobal = '1000FPS';
    const cups = ["gold_cup", "silver_cup", "bronze_cup"];

    function setMapName(name)
    {
        mapNameContainer.innerText = name;
    }

    function createButton(categoryName) {
        const button = document.createElement('button');
        button.className = "toggle-button text-black dark:text-black font-semibold px-2 duration-150 rounded hover:text-blue-800 bg-gray-50";
        button.dataset.category = categoryName;
        button.textContent = categoryName;
        return button;
    }

    function createTableHeaderCell(cellContent) {
        const headerCell = document.createElement('th');
        headerCell.textContent = cellContent;
        const headerCellClasses = "overflow-hidden border-b border-slate-600 dark:border-slate-600 xl:text-base text-xs xl:text-sm p-4 pr-4 pt-2 pb-3 text-slate-200 dark:text-slate-200 text-left";

        switch (cellContent) {
            case "Rank":
                headerCell.className = headerCellClasses + " w-12";
                break;
            case "Name":
                headerCell.className = headerCellClasses + " w-1/4";
                break;
            default:
                headerCell.className = headerCellClasses;
        }

        return headerCell;
    }

    function createTableRow(record) {
        const row = document.createElement('tr');
        const tdClasses = 'border-b border-slate-700 dark:border-slate-700 p-4 pr-4 xl:text-sm text-xs xl:text-sm text-slate-400 dark:text-slate-400';

        const rankCell = document.createElement('td');
        rankCell.className = tdClasses;

        if (record.rank == 1) {
            const link = document.createElement('a');
            link.className = 'flex flex-row';
            link.href = `replay.php?mapId=${params.id}&category=${record.categoryId}`;

            const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
            svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
            svg.setAttribute('fill', 'none');
            svg.setAttribute('viewBox', '0 0 24 24');
            svg.setAttribute('stroke-width', '1.5');
            svg.setAttribute('stroke', 'currentColor');
            svg.classList.value = 'w-4 h-4 hover:fill-blue-500 fill-yellow-400 cursor-pointer duration-150';
            svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />';

            link.appendChild(svg);
            rankCell.appendChild(link);
        } else if (record.rank < 4) {
            const img2 = document.createElement('img');
            img2.style.height = '18px';
            img2.src = `img/cups/${cups[record.rank - 1]}.png`;
            rankCell.appendChild(img2);
        } else {
            rankCell.textContent = record.rank;
        }

        row.appendChild(rankCell);

        const nameCell = document.createElement('td');
        nameCell.className = tdClasses;
        const divName = document.createElement("div");
        divName.className = "flex items-center text-center";
        const img = document.createElement('img');
        img.classList.add('w-6', 'mr-1');
        img.src = 'img/flags/' + record.nationality.toLowerCase() + '.png';
        const nameLink = document.createElement('a');
        nameLink.className = 'hover:text-blue-500 duration-150 cursor-pointer';
        nameLink.href = "player.php?id=" + record.userId;
        nameLink.innerText = record.name;
        divName.appendChild(img);
        divName.appendChild(nameLink);
        nameCell.appendChild(divName);
        row.appendChild(nameCell);

        const timeCell = document.createElement('td');
        timeCell.className = tdClasses;
        timeCell.textContent = record.time;
        row.appendChild(timeCell);

        const recordDateCell = document.createElement('td');
        recordDateCell.className = tdClasses;
        recordDateCell.textContent = record.recorddate;
        row.appendChild(recordDateCell);

        const startSpeedCell = document.createElement('td');
        startSpeedCell.className = tdClasses;
        startSpeedCell.textContent = record.startspeed;
        row.appendChild(startSpeedCell);

        if(loggedin){
            const actionCell = document.createElement('td');
            actionCell.className = tdClasses;
            const deleteBtn = document.createElement('button');
            deleteBtn.innerText = "Delete";
            deleteBtn.onclick = (() => {
                sendPostRequest("./api/delete_time.php", `id=${record.id}&rank=${record.rank}&map=${mapNameContainer.innerText}&category=${categoryNameGlobal}`, function (response) {
                    // Handle the response from the PHP script here
                    console.log(response);
                    row.remove();
                })
            });

            actionCell.appendChild(deleteBtn);
            row.appendChild(actionCell);
        }
        

        return row;
    }

    function populateButtons(records) {
        Object.keys(records).forEach((categoryName) => {
            const button = createButton(categoryName);
            buttonContainer.appendChild(button);
        });

        const toggleCategoryButtons = document.querySelectorAll(".toggle-button");
        const categoryTables = document.querySelectorAll(".category-table");

        let selectedButton = toggleCategoryButtons[0];
        selectedButton.style.background = "rgb(59 130 246)";

        categoryTables[0].style.display = "table";

        toggleCategoryButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const categoryName = button.getAttribute("data-category");

                if (selectedButton) {
                    selectedButton.style.background = "";
                }

                button.style.background = "rgb(59 130 246)";

                categoryTables.forEach((table) => {
                    if (table.getAttribute("data-category") === categoryName) {
                        categoryNameGlobal = categoryName;
                        table.style.display = "table";
                    } else {
                        table.style.display = "none";
                    }
                });

                selectedButton = button;
            });
        });
    }

    function createTable(categoryName, records) {
        const table = document.createElement('table');
        table.classList.add(
            'category-table',
            'border-collapse',
            'table-fixed',
            'w-full',
            'text-sm'
        );
        table.dataset.category = categoryName;
        table.style.display = 'none';

        const thead = document.createElement('thead');
        const headerRow = document.createElement('tr');

        let headerCellContent = [
            'Rank',
            'Name',
            'Time',
            'Record Date',
            'Start Speed',
        ];
        if(loggedin){
            headerCellContent = [
                'Rank',
                'Name',
                'Time',
                'Record Date',
                'Start Speed',
                'Action',
        ];
        }

        headerCellContent.forEach((cellContent) => {
            const headerCell = createTableHeaderCell(cellContent);
            headerRow.appendChild(headerCell);
        });

        thead.appendChild(headerRow);
        table.appendChild(thead);

        const tbody = document.createElement('tbody');
        records[categoryName].forEach((record) => {
            const row = createTableRow(record);
            tbody.appendChild(row);
        });

        table.appendChild(tbody);

        return table;
    }

    function populateTable(records) {
        for (const categoryName in records) {
            if (records.hasOwnProperty(categoryName)) {
                const table = createTable(categoryName, records);
                tableContainer.appendChild(table);
            }
        }
    }

    function fetchRecords(id) {
        const url = 'api/get_map_records.php';
        const data = { id: id };

        fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json',
            },
        })
            .then((response) => response.json())
            .then((records) => {
                populateTable(records);
                populateButtons(records);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

    function fetchMap(id)
    {
        const url = 'api/get_map.php';
        const data = { id: id };

        fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json',
            },
        })
            .then((response) => response.json())
            .then((map) => {
                setMapName(map);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

    
    fetchMap(params.id);
    fetchRecords(params.id);


</script>


<script src="js/search-player.js"></script>