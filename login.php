<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" type="text/css" href="css/globals.css">
    <title>Home</title>
</head>
<body>
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
<div class="flex flex-row justify-center">
    <div class="p-10 mt-20 w-10/12 md:w-5/12 lg:w-3/12 bg-slate-800">
    <form id="login-form" class="p-6 flex flex-col gap-8">
        <div class="flex flex-col gap-2 relative">
          <input
            id="emailInput"
            class="p-2 ring-1 ring-slate-200 bg-white rounded drop-shadow-md"
            type="text"
            placeholder="Email"
          />
        </div>
        <div class="flex flex-col gap-2 relative">
          <input
            id="passwordInput"
            class="p-2 ring-1 ring-slate-200 bg-white rounded drop-shadow-md"
            type="password"
            placeholder="Password"
          />
        </div>
        <div class="w-full flex flex-row justify-around text-lg font-semibold">
          <button class="p-2 w-2/4 bg-green-500 text-white hover:bg-white hover:text-black duration-150 ring-1 rounded">
            Login
          </button>
        </div>
        <div class="w-full flex flex-row justify-around text-md font-semibold">
          <span id="error-message" class=" text-red-600">
            
          </span>
        </div>
      </form>
    </div>
</div>
</body>
</html>

<script>
    function sendPostRequest(url, data, callback) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", url, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          callback(xhr.responseText);
        }
        else if (xhr.status === 403) {
            const errorSpan = document.getElementById("error-message");
            errorSpan.innerText = "Email sau parola gresita!";
        }
      };
      xhr.send(data);
    }

    const form = document.getElementById("login-form");

    form.addEventListener("submit", function (event) {
      event.preventDefault();

      const email = document.getElementById("emailInput").value;
      const password = document.getElementById("passwordInput").value;

      //console.log("email: " + email);
      //console.log("password: " + password);

      if (email === '' || password === '') {
        // highlight car and model input
      }
      else {
        sendPostRequest("api/login.php", `email=${email}&password=${password}`, function (response) {
            // Handle the response from the PHP script here
            console.log(response);
            let info = JSON.parse(response);
            localStorage.setItem("token", info.token);
            localStorage.setItem("name", info.name);
            window.location.replace("/");
        });
      }
        
    });


</script>

<script src="js/search-player.js"></script>