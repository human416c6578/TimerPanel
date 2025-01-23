<!DOCTYPE html>
<?php
require_once "api/db.php"; // Include the file with the db class

// Initialize the database connection
$db = new api\db();

// Get player data from the database
$playerData = json_decode($db->get_player($_GET['id']), true);

// Define a default playerSteam array
$playerSteam = ["avatarfull" => "img/profile.jpg"];

if (isset($playerData['steamid'])) {
    // Extract Steam ID parts
    $accountarray	=	explode(":", $playerData['steamid']);
    $idnum			=	$accountarray[1];
    $accountnum		=	$accountarray[2];
    $constant		=	'76561197960265728';
    $steamid64 = bcadd(bcmul($accountnum, 2), bcadd($idnum, $constant));

    // Make API request to Steam
    $steamkey = "9EA52933A3FC8BF919DC98660B94FCE6";
    $url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$steamkey&steamids=$steamid64&avatar";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);

    // Parse and assign playerSteam data
    $result = json_decode($result, true);

    if (isset($result['response']['players'][0])) {
        $playerSteam = $result['response']['players'][0];
    }
} else {
    $playerData['steamid'] = "NOT FOUND!";
}
?>

<!doctype html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/globals.css">
	<script src="https://cdn.tailwindcss.com"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom"></script>
	<script src="js/hammer.min.js"></script>
</head>
<!-- NavBar -->
<nav class="bg-gray-900 dark:bg-gray-900 border-gray-200">
	<div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
		<a href="/panel" class="flex items-center">
			<img src="img/logo.png" class="h-8 mr-3" alt="LaLeagane" />
			<span class="self-center text-2xl font-semibold text-white dark:text-white whitespace-nowrap">Bhop
				Panel</span>
		</a>
		<div class="flex md:order-2">
			<button id="toggleSearchButton" type="button"
				class="md:hidden text-gray-400 dark:text-gray-400 hover:bg-gray-700 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-700 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 mr-1">
				<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
					viewBox="0 0 20 20">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
						d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
				</svg>
				<span class="sr-only">Search</span>
			</button>
			<div class="relative hidden md:block">
				<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
					<svg class="w-4 h-4 text-gray-400 dark:text-gray-400" aria-hidden="true"
						xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
					</svg>
					<span class="sr-only">Search icon</span>
				</div>
				<input type="text" id="search-navbar"
					class="block w-full p-2 pl-10 text-sm border rounded-lg bg-gray-700 dark:bg-gray-700 border-gray-600 dark:border-gray-600 placeholder-gray-400 dark:placeholder-gray-400 text-white dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500"
					placeholder="Search player...">
				<ul id="searchList"
					class="absolute z-20 w-full right-0 bg-gray-900 rounded text-start text-lg text-white font-semibold">

				</ul>
			</div>

			<button id="toggleMenuButton" type="button"
				class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm rounded-lg md:hidden focus:outline-none focus:ring-2 text-gray-400 dark:text-gray-400 hover:bg-gray-700 dark:hover:bg-gray-700 focus:ring-gray-600 dark:focus:ring-gray-600"
				aria-controls="navbar-search" aria-expanded="false">
				<span class="sr-only">Open main menu</span>
				<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
					viewBox="0 0 17 14">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
						d="M1 1h15M1 7h15M1 13h15" />
				</svg>
			</button>
		</div>

		<div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-menu">
			<div class="relative mt-3 md:hidden">
				<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
					<svg class="w-4 h-4 text-gray-400 dark:text-gray-400" aria-hidden="true"
						xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
					</svg>
				</div>
				<input type="text" id="search-navbar-mobile"
					class="block w-full p-2 pl-10 text-sm border rounded-lg bg-gray-700 dark:bg-gray-700 border-gray-600 dark:border-gray-600 placeholder-gray-400 dark:placeholder-gray-400 text-white dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500"
					placeholder="Search player...">
				<ul id="searchListMobile"
					class="absolute z-20 w-full right-0 bg-gray-900 rounded text-start text-lg text-white font-semibold">
				</ul>
			</div>
			<ul
				class="flex flex-col p-4 md:p-0 mt-4 font-medium border rounded-lg md:flex-row md:space-x-8 md:mt-0 md:border-0 bg-gray-800 dark:bg-gray-800 border-gray-700 dark:border-gray-700 md:bg-gray-900 md:dark:bg-gray-900">
				<li>
					<a href="/panel"
						class="block py-2 pl-3 pr-4 rounded md:hover:bg-transparent md:p-0 text-white dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 hover:text-white dark:hover:text-white md:dark:hover:bg-transparent border-gray-700 dark:border-gray-700 md:hover:text-blue-700 md:dark:hover:text-blue-500">Home</a>
				</li>
				<li>
					<a href="records.php"
						class="block py-2 pl-3 pr-4 rounded md:hover:bg-transparent md:p-0 text-white dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 hover:text-white dark:hover:text-white md:dark:hover:bg-transparent border-gray-700 dark:border-gray-700 md:hover:text-blue-700 md:dark:hover:text-blue-500">Records</a>
				</li>
				<li>
					<a href="top.php"
						class="block py-2 pl-3 pr-4 rounded md:hover:bg-transparent md:p-0 text-white dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 hover:text-white dark:hover:text-white md:dark:hover:bg-transparent border-gray-700 dark:border-gray-700 md:hover:text-blue-700 md:dark:hover:text-blue-500">Top</a>
				</li>
				<li>
                    <a href="logs.php" class="block py-2 pl-3 pr-4 rounded md:hover:bg-transparent md:p-0 text-white dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 hover:text-white dark:hover:text-white md:dark:hover:bg-transparent border-gray-700 dark:border-gray-700 md:hover:text-blue-700 md:dark:hover:text-blue-500">Logs</a>
                </li>
				<li>
					<a href="https://discord.gg/r8k5J3TASC"
						class="block py-2 pl-3 pr-4 rounded md:hover:bg-transparent md:p-0 text-white dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 hover:text-white dark:hover:text-white md:dark:hover:bg-transparent border-gray-700 dark:border-gray-700 md:hover:text-blue-700 md:dark:hover:text-blue-500">Discord</a>
				</li>
				<li>
					<a href="https://laleagane.ro/forum/forums/bhop.43633/"
						class="block py-2 pl-3 pr-4 rounded md:hover:bg-transparent md:p-0 text-white dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 hover:text-white dark:hover:text-white md:dark:hover:bg-transparent border-gray-700 dark:border-gray-700 md:hover:text-blue-700 md:dark:hover:text-blue-500">Forum</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
<!-- Body -->
<div class="relative flex min-h-screen flex-col overflow-hidden bg-gray-50 py-6 sm:py-12">
	<img src="img/beams.jpg" alt="" class="absolute left-1/2 top-1/2 max-w-none -translate-x-1/2 -translate-y-1/2"
		width="1308" />
	<div
		class="absolute inset-0 bg-[url(img/grid.svg)] bg-center [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]">
	</div>
	<div
		class="relative flex min-h-screen overflow-hidden flex-col xl:flex-row items-center xl:items-start xl:justify-around justify-start space-y-8 xl:space-y-0">
		<div
			class="p-4 relative flex flex-col sm:flex-row justify-around overflow-hidden bg-gray-900 dark:bg-gray-900 rounded xl:w-fit w-fit z-10 space-y-2 sm:space-x-8">
			<!-- Profile -->
			<div class="flex flex-col">
				<img class="self-center p-1 w-40 h-40 rounded bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90%"
					src="<?php echo $playerSteam["avatarfull"] ?>" />
				<div class="flex flex-row items-center justify-center space-x-2">
					<?php
                        if(isset($playerSteam["loccountrycode"]))
                            echo '<img class="m-2 w-8 h-6 rounded ring-1 ring-cyan-500" src="img/flags/'.strtolower($playerSteam["loccountrycode"]).'.png" />';
                        ?>
					<?php
                        if(isset($playerSteam["profileurl"])) {
                            echo '<a href="' . $playerSteam["profileurl"] . '" class="self-center m-2 py-1 px-2 font-semibold text-lg bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% rounded">'.mb_convert_encoding($playerData["name"], 'UTF-8', "auto").'</a>';
                        }
                        else{
                            echo '<span class="self-center m-2 py-1 px-2 font-semibold text-lg bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% rounded">'.mb_convert_encoding($playerData["name"], 'UTF-8', "auto").'</span>';
                        }
                        ?>
				</div>
				<div class="flex flex-col">
					<span
						class="self-center m-2 py-1 px-2 font-semibold text-md bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% rounded ring-1 ring-cyan-500"><?php echo$playerData["steamid"]?>
					</span>
				</div>
				<div id="deleteBtn" style="display:none" class="flex flex-col">
					<button
						class="self-center m-2 py-1 px-4 font-semibold text-md text-white bg-red-500 rounded hover:bg-white hover:text-red-500 transition-colors duration-300"
						onclick="deleteRecords()">Delete Player Records
					</button>

				</div>
			</div>
			<!-- Stats -->
			<div class="flex flex-col text-md font-semibold text-white dark:text-white">
				<div class="flex flex-row justify-between">
					<span
						class="self-center m-2 py-1 px-2 font-semibold text-md bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% rounded ring-1 ring-cyan-500">Rank</span>
					<span
						class="m-2 py-1 px-4 bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% rounded"><?php echo $playerData["rank"] ?></span>
				</div>
				<div class="flex flex-row justify-between">
					<span
						class="self-center m-2 py-1 px-2 font-semibold text-md bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% rounded ring-1 ring-cyan-500">Score</span>
					<span
						class="m-2 py-1 px-4 bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% rounded"><?php echo $playerData["score"] ?></span>
				</div>
				<div class="flex flex-row justify-between">
					<span
						class="self-center m-2 py-1 px-2 font-semibold text-md bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% rounded ring-1 ring-cyan-500">Runs</span>
					<span
						class="m-2 py-1 px-4 bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% rounded"><?php echo $playerData["runs"] ?></span>
				</div>
				<!--
                    <div class="flex flex-row justify-between">
                        <span class="self-center m-2 py-1 px-2 font-semibold text-md bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% rounded ring-1 ring-cyan-500">WR</span>
                        <span id="wrCount" class="m-2 py-1 px-4 bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% rounded">?php echo $playerData["wrs"] ?></span>
                    </div>
                    -->
				<div class="flex flex-row justify-between">
					<span
						class="self-center m-2 py-1 px-2 font-semibold text-md bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% rounded ring-1 ring-cyan-500">Time</span>
					<span
						class="m-2 py-1 px-4 bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% rounded"><?php echo $playerData["time"]."h" ?></span>
				</div>
				<div
					class="flex flex-row justify-center space-x-6 mt-6 text-md font-semibold text-white dark:text-white">
					<div class="flex flex-row justify-center items-center">
						<img class="w-12 mr-2" src="img/medals/bronze.png" />
						<span class="text-amber-600 font-bold text-2xl"><?php echo $playerData["bronze"] ?></span>
					</div>
					<div class="flex flex-row justify-center items-center">
						<img class="w-12 mr-2" src="img/medals/silver.png" />
						<span class="text-gray-300 font-bold text-2xl"><?php echo $playerData["silver"] ?></span>
					</div>
					<div class="flex flex-row justify-center items-center">
						<img class="w-12 mr-2" src="img/medals/gold.png" />
						<span class="text-yellow-300 font-bold text-2xl"><?php echo $playerData["gold"] ?></span>
					</div>
				</div>
			</div>
		</div>

		<div
			class="relative flex flex-col justify-center overflow-hidden bg-gradient-to-r from-blue-500 to-red-500 rounded h-2/6 xl:w-7/12 w-full py-6 xl:px-6 px-0 z-10">
			<div id="button-container" class="self-center w-fit flex flex-row justify-center space-x-2">
				<button id="activity-button" onclick="displayActivity()"
					class="px-4 text-slate-100 dark:text-slate-100 font-semibold text-xl px-2 duration-150 rounded hover:text-black hover:bg-white bg-slate-800">Activity</button>
				<button id="records-button" onclick="displayRecords()"
					class="px-4 text-slate-100 dark:text-slate-100 font-semibold text-xl px-2 duration-150 rounded hover:text-black hover:bg-white bg-slate-800">Records</button>
				<button id="medals-button" onclick="displayMedals()"
					class="px-4 text-slate-100 dark:text-slate-100 font-semibold text-xl px-2 duration-150 rounded hover:text-black hover:bg-white bg-slate-800">Medals</button>
			</div>
			<div id="activity-container">
				<div class="flex flex-row justify-around mb-3">
					<div id="customLegend" class="legend"></div>
					<canvas id="activityChart"></canvas>
				</div>
			</div>
			<div id="records-container">
				<div class="flex flex-row justify-around mb-3">
					<div class="relative mt-3">
						<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
							<svg class="w-4 h-4 text-gray-400 dark:text-gray-400" aria-hidden="true"
								xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
								<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
									stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
							</svg>
						</div>
						<input type="text" id="recordMapSearch"
							class="block w-full p-2 pl-10 text-sm border rounded-lg bg-gray-700 dark:bg-gray-700 border-gray-600 dark:border-gray-600 placeholder-gray-400 dark:placeholder-gray-400 text-white dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500"
							placeholder="Search map...">
					</div>
					<div class="relative mt-3">
						<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
							<svg class="w-4 h-4 text-gray-400 dark:text-gray-400" aria-hidden="true"
								xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
								<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
									stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
							</svg>
						</div>
						<input type="text" id="recordCategorySearch"
							class="block w-full p-2 pl-10 text-sm border rounded-lg bg-gray-700 dark:bg-gray-700 border-gray-600 dark:border-gray-600 placeholder-gray-400 dark:placeholder-gray-400 text-white dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500"
							placeholder="Search category...">
					</div>
				</div>
				<div class="not-prose relative rounded-xl overflow-hidden bg-slate-800 dark:bg-slate-800">
					<div class="absolute inset-0 [mask-image:linear-gradient(0deg,#fff,rgba(255,255,255,0.6))] bg-grid-slate-700/25 dark:bg-grid-slate-700/25 dark:[mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]"
						style="background-position: 10px 10px;"></div>
					<div class="relative rounded-xl overflow-auto">
						<div class="shadow-sm overflow-hidden my-4">
							<table id="records-table" class="category-table border-collapse table-fixed w-full text-sm">
								<thead>
									<tr>
										<th
											class="w-20 overflow-hidden border-b border-slate-600 dark:border-slate-600 xl:text-sm text-xs xl:text-medium p-4 pr-4 pt-2 pb-3 text-slate-200 dark:text-slate-200 text-left">
											<div class="relative flex flex-row justify-start">
												Rank
												<svg id="sortRank" xmlns="http://www.w3.org/2000/svg" fill="none"
													viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
													class="w-4 h-4 hover:stroke-blue-500 cursor-pointer duration-150">
													<path stroke-linecap="round" stroke-linejoin="round"
														d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
												</svg>

											</div>
										</th>
										<th
											class="w-1/4 overflow-hidden border-b border-slate-600 dark:border-slate-600 xl:text-sm text-xs xl:text-medium p-4 pr-4 pt-2 pb-3 text-slate-200 dark:text-slate-200 text-left">
											<div class="flex flex-row justify-start">
												Map
												<svg id="sortMap" xmlns="http://www.w3.org/2000/svg" fill="none"
													viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
													class="w-4 h-4 hover:stroke-blue-500 cursor-pointer duration-150">
													<path stroke-linecap="round" stroke-linejoin="round"
														d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
												</svg>
											</div>
										</th>
										<th
											class="border-b border-slate-600 dark:border-slate-600 xl:text-sm text-xs xl:text-medium p-4 pr-4 pt-2 pb-3 text-slate-200 dark:text-slate-200 text-left">
											<div class="flex flex-row justify-start">
												Category
												<svg id="sortCategory" xmlns="http://www.w3.org/2000/svg" fill="none"
													viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
													class="w-4 h-4 hover:stroke-blue-500 cursor-pointer duration-150">
													<path stroke-linecap="round" stroke-linejoin="round"
														d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
												</svg>
											</div>
										</th>
										<th
											class="border-b border-slate-600 dark:border-slate-600 xl:text-sm text-xs xl:text-medium p-4 pr-4 pt-2 pb-3 text-slate-200 dark:text-slate-200 text-left">
											<div class="flex flex-row justify-start">
												Time
												<svg id="sortTime" xmlns="http://www.w3.org/2000/svg" fill="none"
													viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
													class="w-4 h-4 hover:stroke-blue-500 cursor-pointer duration-150">
													<path stroke-linecap="round" stroke-linejoin="round"
														d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
												</svg>
											</div>
										</th>
										<th
											class="border-b border-slate-600 dark:border-slate-600 xl:text-sm text-xs xl:text-medium p-4 pr-4 pt-2 pb-3 text-slate-200 dark:text-slate-200 text-left xl:table-cell hidden">
											<div class="flex flex-row justify-start">
												Record Date
												<svg id="sortDate" xmlns="http://www.w3.org/2000/svg" fill="none"
													viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
													class="w-4 h-4 hover:stroke-blue-500 cursor-pointer duration-150">
													<path stroke-linecap="round" stroke-linejoin="round"
														d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
												</svg>
											</div>
										</th>
										<th
											class="border-b border-slate-600 dark:border-slate-600 xl:text-sm text-xs xl:text-medium p-4 pr-4 pt-2 pb-3 text-slate-200 dark:text-slate-200 text-left xl:table-cell hidden">
											<div class="flex flex-row justify-start">
												Start Speed
												<svg id="sortSpeed" xmlns="http://www.w3.org/2000/svg" fill="none"
													viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
													class="w-4 h-4 hover:stroke-blue-500 cursor-pointer duration-150">
													<path stroke-linecap="round" stroke-linejoin="round"
														d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
												</svg>
											</div>
										</th>
									</tr>
								</thead>
								<tbody id="records-body">

								</tbody>
							</table>
							<div class="flex flex-col items-center pt-2">
								<!-- Help text -->
								<span class="text-sm text-gray-700 dark:text-gray-400">
									Showing <span id="startEntry"
										class="font-semibold text-gray-900 dark:text-white">1</span> to <span
										id="endEntry" class="font-semibold text-gray-900 dark:text-white">10</span> of
									<span id="totalEntries"
										class="font-semibold text-gray-900 dark:text-white">100</span> Entries
								</span>
								<!-- Buttons -->
								<div class="inline-flex mt-2 xs:mt-0">
									<button id="prevPage"
										class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 rounded-l hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
										Prev
									</button>
									<button id="nextPage"
										class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 border-0 border-l border-gray-700 rounded-r hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
										Next
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="medals-container">
				<div class="flex flex-row justify-around mb-3">
					<div class="relative mt-3">
						<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
							<svg class="w-4 h-4 text-gray-400 dark:text-gray-400" aria-hidden="true"
								xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
								<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
									stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
							</svg>
						</div>
						<input type="text" id="medalsMapSearch"
							class="block w-full p-2 pl-10 text-sm border rounded-lg bg-gray-700 dark:bg-gray-700 border-gray-600 dark:border-gray-600 placeholder-gray-400 dark:placeholder-gray-400 text-white dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500"
							placeholder="Search map...">
					</div>
				</div>
				<div class="not-prose relative rounded-xl overflow-hidden bg-slate-800 dark:bg-slate-800">
					<div class="absolute inset-0 [mask-image:linear-gradient(0deg,#fff,rgba(255,255,255,0.6))] bg-grid-slate-700/25 dark:bg-grid-slate-700/25 dark:[mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]"
						style="background-position: 10px 10px;"></div>
					<div class="relative rounded-xl overflow-auto">
						<div class="shadow-sm overflow-hidden my-4">
							<table id="records-table" class="category-table border-collapse table-fixed w-full text-sm">
								<thead>
									<tr>
										<th
											class="w-1/4 overflow-hidden border-b border-slate-600 dark:border-slate-600 xl:text-sm text-xs xl:text-medium p-4 pr-4 pt-2 pb-3 text-slate-200 dark:text-slate-200 text-left">
											Map
										</th>
										<th
											class="border-b border-slate-600 dark:border-slate-600 xl:text-sm text-xs xl:text-medium p-4 pr-4 pt-2 pb-3 text-slate-200 dark:text-slate-200 text-left">
											<div class="flex flex-row justify-start">
												Bronze
												<svg id="sortBronze" xmlns="http://www.w3.org/2000/svg" fill="none"
													viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
													class="w-4 h-4 hover:stroke-blue-500 cursor-pointer duration-150">
													<path stroke-linecap="round" stroke-linejoin="round"
														d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
												</svg>
											</div>
										</th>
										<th
											class="border-b border-slate-600 dark:border-slate-600 xl:text-sm text-xs xl:text-medium p-4 pr-4 pt-2 pb-3 text-slate-200 dark:text-slate-200 text-left">
											<div class="flex flex-row justify-start">
												Silver
												<svg id="sortSilver" xmlns="http://www.w3.org/2000/svg" fill="none"
													viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
													class="w-4 h-4 hover:stroke-blue-500 cursor-pointer duration-150">
													<path stroke-linecap="round" stroke-linejoin="round"
														d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
												</svg>
											</div>
										</th>
										<th
											class="border-b border-slate-600 dark:border-slate-600 xl:text-sm text-xs xl:text-medium p-4 pr-4 pt-2 pb-3 text-slate-200 dark:text-slate-200 text-left">
											<div class="flex flex-row justify-start">
												Gold
												<svg id="sortGold" xmlns="http://www.w3.org/2000/svg" fill="none"
													viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
													class="w-4 h-4 hover:stroke-blue-500 cursor-pointer duration-150">
													<path stroke-linecap="round" stroke-linejoin="round"
														d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
												</svg>
											</div>
										</th>
									</tr>
								</thead>
								<tbody id="medals-body">

								</tbody>
							</table>
							<div class="flex flex-col items-center pt-2">
								<!-- Help text -->
								<span class="text-sm text-gray-700 dark:text-gray-400">
									Showing <span id="startMedalsEntry"
										class="font-semibold text-gray-900 dark:text-white">1</span> to <span
										id="endMedalsEntry"
										class="font-semibold text-gray-900 dark:text-white">10</span> of <span
										id="totalMedalsEntries"
										class="font-semibold text-gray-900 dark:text-white">100</span> Entries
								</span>
								<!-- Buttons -->
								<div class="inline-flex mt-2 xs:mt-0">
									<button id="prevMedalsPage"
										class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 rounded-l hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
										Prev
									</button>
									<button id="nextMedalsPage"
										class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 border-0 border-l border-gray-700 rounded-r hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
										Next
									</button>
								</div>
							</div>
						</div>
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
					<a href="https://laleagane.ro/forum/forums/bhop.43633/"
						class="mr-4 hover:underline md:mr-6">Forum</a>
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
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
					stroke="currentColor" class="stroke-white mx-2 w-6 h-6">
					<path stroke-linecap="round" stroke-linejoin="round"
						d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
				</svg>
				<span
					class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">human416c6578@gmail.com</span>
			</div>
			<div class="flex flex-row items-center">
				<img class="mx-2 w-6" src="img/misc/discord.png" />
				<span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">@MrShark45</span>
			</div>

			<div class="flex flex-row items-center">
				<img class="mx-2 w-6" src="img/misc/steam.png" />
				<a href="https://steamcommunity.com/id/mrshark45"
					class="block text-sm text-gray-500 sm:text-center dark:text-gray-400 hover:underline">MrShark45</a>
			</div>

		</div>


	</div>
</footer>

</html>


<script>
let loggedin = false;

function sendPostRequest(url, data, callback) {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.setRequestHeader("Authorization", localStorage.getItem("token"));
	xhr.onreadystatechange = function() {
		if (xhr.readyState === 4 && xhr.status === 200) {
			callback(xhr.responseText);
		} else if (xhr.status === 403) {
			//
		}
	};
	xhr.send(data);
}

sendPostRequest("./api/login.php", ``, function(response) {
	loggedin = true;
	let deleteBtn = document.getElementById("deleteBtn");
	deleteBtn.style.display = "block";
});

function deleteRecords() {
	const params = getUrlParams();
	const name = <?php echo json_encode(mb_convert_encoding($playerData["name"], 'UTF-8', "auto")); ?>;
	if (confirm(
			`You are going to delete all records of player ${name} (ID: ${params.id}).\nAre you sure?`
		)) {

		const rank1Records = playerRecords.filter(record => record.rank === 1);
		const rank1RecordsJson = JSON.stringify(rank1Records);

		sendPostRequest("./api/delete_player.php",
			`id=${params.id}&rank1Records=${encodeURIComponent(rank1RecordsJson)}`,
			function(response) {
				console.log(response);
			}
		);
		alert(
			`You deleted all records for user ${name} (ID: ${params.id}).`
		);
	}
}

function getUrlParams() {
	const searchParams = new URLSearchParams(window.location.search);
	const params = {};

	for (const [key, value] of searchParams.entries()) {
		params[key] = value;
	}

	return params;
}
</script>

<script>
let recordsContainer = document.getElementById("records-container");
let medalsContainer = document.getElementById("medals-container");
let activityContainer = document.getElementById("activity-container");

medalsContainer.style.display = 'none';
recordsContainer.style.display = 'none';

function displayRecords() {
	recordsContainer.style.display = 'block';
	medalsContainer.style.display = 'none';
	activityContainer.style.display = 'none';
}

function displayMedals() {
	recordsContainer.style.display = 'none';
	medalsContainer.style.display = 'block';
	activityContainer.style.display = 'none';
}

function displayActivity() {
	recordsContainer.style.display = 'none';
	medalsContainer.style.display = 'none';
	activityContainer.style.display = 'block';
}
</script>

<script>
let playerRecords = [];
let filteredRecords = [];
function recordsTable() {
	const cups = ["gold_cup", "silver_cup", "bronze_cup"];
	const itemsPerPage = 10; // Number of records to display per page
	let currentPage = 1;
	let totalPages = 1;

	const sortCriteria = {
		column: 'date', // Default sorting column
		order: 'desc', // Default sorting order ('asc' or 'desc')
	};

	const mapSearch = document.getElementById("recordMapSearch");
	const categorySearch = document.getElementById("recordCategorySearch");
	const prevPageButton = document.getElementById('prevPage');
	const nextPageButton = document.getElementById('nextPage');
	const startEntrySpan = document.getElementById('startEntry');
	const endEntrySpan = document.getElementById('endEntry');
	const totalEntriesSpan = document.getElementById('totalEntries');

	const sortRankSpan = document.getElementById('sortRank');
	const sortMapSpan = document.getElementById('sortMap');
	const sortCategorySpan = document.getElementById('sortCategory');
	const sortTimeSpan = document.getElementById('sortTime');
	const sortDateSpan = document.getElementById('sortDate');
	const sortSpeedSpan = document.getElementById('sortSpeed');

	sortRankSpan.addEventListener("click", function() {
		updateSortCriteria('rank');
		applySort();
		toggleArrowPath(sortRankSpan);
	});
	sortMapSpan.addEventListener("click", function() {
		updateSortCriteria('map');
		applySort();
		toggleArrowPath(sortMapSpan);
	});
	sortCategorySpan.addEventListener("click", function() {
		updateSortCriteria('category');
		applySort();
		toggleArrowPath(sortCategorySpan);
	});
	sortTimeSpan.addEventListener("click", function() {
		updateSortCriteria('time');
		applySort();
		toggleArrowPath(sortTimeSpan);
	});
	sortDateSpan.addEventListener("click", function() {
		updateSortCriteria('recorddate');
		applySort();
		toggleArrowPath(sortDateSpan);
	});
	sortSpeedSpan.addEventListener("click", function() {
		updateSortCriteria('startspeed');
		applySort();
		toggleArrowPath(sortSpeedSpan);
	});


	mapSearch.addEventListener("input", function() {
		applyFilters();
	});

	categorySearch.addEventListener("input", function() {
		applyFilters();
	});

	prevPageButton.addEventListener('click', () => {
		if (currentPage > 1) {
			currentPage--;
			populateTable(filteredRecords);
			updatePagination();
		}
	});

	nextPageButton.addEventListener('click', () => {
		if (currentPage < totalPages) {
			currentPage++;
			populateTable(filteredRecords);
			updatePagination();
		}
	});

	function applySort() {
		// Sort the filteredRecords array based on sortCriteria
		filteredRecords.sort((a, b) => {
			const valueA = a[sortCriteria.column];
			const valueB = b[sortCriteria.column];

			if (sortCriteria.column === 'startspeed' || sortCriteria.column === 'rank') {
				// Convert string rank or startspeed to numeric values for sorting
				const numericValueA = parseInt(valueA);
				const numericValueB = parseInt(valueB);

				if (sortCriteria.order === 'asc') {
					return numericValueA - numericValueB;
				} else {
					return numericValueB - numericValueA;
				}
			} else if (sortCriteria.column === 'recorddate') {
				// Convert date strings to Date objects for sorting
				const dateA = new Date(valueA);
				const dateB = new Date(valueB);

				if (sortCriteria.order === 'asc') {
					return dateA - dateB;
				} else {
					return dateB - dateA;
				}
			} else {
				// Default string sorting for other columns
				if (sortCriteria.order === 'asc') {
					return valueA.localeCompare(valueB);
				} else {
					return valueB.localeCompare(valueA);
				}
			}
		});

		// Call populateTable with the sorted filteredRecords
		populateTable(filteredRecords);
	}

	function applyFilters() {
		filteredRecords = playerRecords.filter(record => {
			const mapMatch = mapSearch.value.length ? record.map.toLowerCase().includes(mapSearch.value
				.toLowerCase()) : true;
			const categoryMatch = categorySearch.value.length ? record.category.toLowerCase().includes(
				categorySearch.value.toLowerCase()) : true;
			return mapMatch && categoryMatch;
		})

		// Update pagination controls and display records for the current page
		populateTable(filteredRecords);
		updatePagination();
	}

	function updateSortCriteria(column) {
		resetArrowPaths();
		// Toggle sorting order if the same column is clicked again
		if (sortCriteria.column === column) {
			sortCriteria.order = sortCriteria.order === 'asc' ? 'desc' : 'asc';
		} else {
			// Set the sorting column and reset the order to ascending
			sortCriteria.column = column;
			sortCriteria.order = 'asc';
		}
	}

	function updatePagination() {
		prevPageButton.disabled = currentPage === 1;
		nextPageButton.disabled = currentPage === totalPages;
	}

	function toggleArrowPath(element) {
		if (sortCriteria.order === 'asc') {
			element.innerHTML =
				'<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />'; // Change to ascending arrow
		} else {
			element.innerHTML =
				'<path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" />'; // Change to descending arrow
		}
	}
	// Function to reset arrow paths for all sorting headers
	function resetArrowPaths() {
		sortRankSpan.innerHTML =
			'<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />';
		sortMapSpan.innerHTML =
			'<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />';
		sortCategorySpan.innerHTML =
			'<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />';
		sortTimeSpan.innerHTML =
			'<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />';
		sortDateSpan.innerHTML =
			'<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />';
		sortSpeedSpan.innerHTML =
			'<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />';
	}

	function populateTable(records) {
		// Get a reference to the table body
		const tableBody = document.querySelector('#records-body');

		// Calculate the total number of pages based on filtered records
		totalPages = Math.ceil(records.length / itemsPerPage);

		// Ensure current page is within bounds
		currentPage = Math.min(Math.max(currentPage, 1), totalPages);

		const startIndex = (currentPage - 1) * itemsPerPage;
		const endIndex = Math.min(startIndex + itemsPerPage, records.length);

		startEntrySpan.innerText = startIndex.toString();
		endEntrySpan.innerText = endIndex.toString();
		totalEntriesSpan.innerText = records.length.toString();


		const tdClasses =
			'border-b border-slate-700 dark:border-slate-700 p-4 pr-4 xl:text-sm text-xs xl:text-medium text-slate-400 dark:text-slate-400';

		// Clear the table body
		tableBody.innerHTML = '';

		// Loop through the records array
		for (let i = startIndex; i < endIndex; i++) {
			const record = records[i];
			let row = document.createElement('tr');

			let rankCell = document.createElement('td');
			rankCell.className = tdClasses;

			if (record.rank === 1) {
				let link = document.createElement('a');
				link.className = 'flex flex-row';
				link.href = `replay.php?mapId=${record.mapId}&category=${record.categoryId}`;

				let svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
				svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
				svg.setAttribute('fill', 'none');
				svg.setAttribute('viewBox', '0 0 24 24');
				svg.setAttribute('stroke-width', '1.5');
				svg.setAttribute('stroke', 'currentColor');
				svg.classList.value = 'w-4 h-4 hover:fill-blue-500 fill-yellow-400 cursor-pointer duration-150';
				svg.innerHTML =
					'<path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />';

				link.appendChild(svg);
				rankCell.appendChild(link);
			} else if (record.rank < 4) {
				let img2 = document.createElement('img');
				img2.style.height = '18px';
				img2.src = `img/cups/${cups[record.rank - 1]}.png`;
				rankCell.appendChild(img2);
			} else {
				rankCell.textContent = record.rank;
			}

			row.appendChild(rankCell);

			let mapCell = document.createElement('td');
			mapCell.className = tdClasses + " overflow-hidden";
			let mapLink = document.createElement('a');
			mapLink.className = 'hover:text-blue-500 duration-150 cursor-pointer';
			mapLink.href = "map.php?id=" + record.mapId;
			mapLink.innerText = record.map;
			mapCell.appendChild(mapLink);
			row.appendChild(mapCell);

			let categoryCell = document.createElement('td');
			categoryCell.className = tdClasses;
			categoryCell.textContent = record.category;
			row.appendChild(categoryCell);

			let timeCell = document.createElement('td');
			timeCell.className = tdClasses;
			timeCell.textContent = record.time;
			row.appendChild(timeCell);

			let recordDateCell = document.createElement('td');
			recordDateCell.className = tdClasses + " hidden xl:table-cell";
			recordDateCell.textContent = record.recorddate;
			row.appendChild(recordDateCell);

			let startspeedCell = document.createElement('td');
			startspeedCell.className = tdClasses + " hidden xl:table-cell";
			startspeedCell.textContent = record.startspeed;
			row.appendChild(startspeedCell);

			// Append the row to the table body
			tableBody.appendChild(row);
		}
	}

	function fetchRecords(id) {
		// URL to your PHP script
		const url = 'api/get_player_records.php';

		// Create an object with the search criteria
		const data = {
			id: id,
		};

		// Send a POST request to the PHP script
		fetch(url, {
				method: 'POST',
				body: JSON.stringify(data),
				headers: {
					'Content-Type': 'application/json'
				}
			})
			.then(response => response.json())
			.then(records => {
				playerRecords = records;
				filteredRecords = records;
				populateTable(records);
				updatePagination();
			})
			.catch(error => {
				console.error('Error:', error);
			});
	}

	const params = getUrlParams();
	fetchRecords(params.id);

	function getUrlParams() {
		const searchParams = new URLSearchParams(window.location.search);
		const params = {};

		for (const [key, value] of searchParams.entries()) {
			params[key] = value;
		}

		return params;
	}
}
recordsTable();
</script>

<script>
function medalsTable() {
	let playerMedals = [];
	let filteredMedals = [];
	const itemsPerPage = 10; // Number of records to display per page
	let currentPage = 1;
	let totalPages = 1;

	const sortCriteria = {
		column: 'date', // Default sorting column
		order: 'desc', // Default sorting order ('asc' or 'desc')
	};

	const mapSearch = document.getElementById("medalsMapSearch");
	const prevPageButton = document.getElementById('prevMedalsPage');
	const nextPageButton = document.getElementById('nextMedalsPage');
	const startEntrySpan = document.getElementById('startMedalsEntry');
	const endEntrySpan = document.getElementById('endMedalsEntry');
	const totalEntriesSpan = document.getElementById('totalMedalsEntries');

	const sortBronzeSpan = document.getElementById('sortBronze');
	const sortSilverSpan = document.getElementById('sortSilver');
	const sortGoldSpan = document.getElementById('sortGold');

	sortBronzeSpan.addEventListener("click", function() {
		updateSortCriteria('bronze');
		applySort();
		toggleArrowPath(sortBronzeSpan);
	});
	sortSilverSpan.addEventListener("click", function() {
		updateSortCriteria('silver');
		applySort();
		toggleArrowPath(sortSilverSpan);
	});
	sortGoldSpan.addEventListener("click", function() {
		updateSortCriteria('gold');
		applySort();
		toggleArrowPath(sortGoldSpan);
	});


	mapSearch.addEventListener("input", function() {
		applyFilters();
	});

	prevPageButton.addEventListener('click', () => {
		if (currentPage > 1) {
			currentPage--;
			populateTable(filteredMedals);
			updatePagination();
		}
	});

	nextPageButton.addEventListener('click', () => {
		if (currentPage < totalPages) {
			currentPage++;
			populateTable(filteredMedals);
			updatePagination();
		}
	});

	function applySort() {
		// Sort the filteredRecords array based on sortCriteria
		filteredMedals.sort((a, b) => {
			const valueA = a[sortCriteria.column];
			const valueB = b[sortCriteria.column];

			if (sortCriteria.column === 'map') {
				// Default string sorting for other columns
				if (sortCriteria.order === 'asc') {
					return valueA.localeCompare(valueB);
				} else {
					return valueB.localeCompare(valueA);
				}
			} else {
				// Convert string rank or startspeed to numeric values for sorting
				const numericValueA = parseInt(valueA);
				const numericValueB = parseInt(valueB);

				if (sortCriteria.order === 'asc') {
					return numericValueA - numericValueB;
				} else {
					return numericValueB - numericValueA;
				}
			}
		});

		// Call populateTable with the sorted filteredRecords
		populateTable(filteredMedals);
	}

	function applyFilters() {
		filteredMedals = playerMedals.filter(record => {
			const mapMatch = mapSearch.value.length ? record.map.toLowerCase().includes(mapSearch.value
				.toLowerCase()) : true;
			return mapMatch;
		})

		// Update pagination controls and display records for the current page
		populateTable(filteredMedals);
		updatePagination();
	}

	function updateSortCriteria(column) {
		resetArrowPaths();
		// Toggle sorting order if the same column is clicked again
		if (sortCriteria.column === column) {
			sortCriteria.order = sortCriteria.order === 'asc' ? 'desc' : 'asc';
		} else {
			// Set the sorting column and reset the order to ascending
			sortCriteria.column = column;
			sortCriteria.order = 'asc';
		}
	}

	function updatePagination() {
		prevPageButton.disabled = currentPage === 1;
		nextPageButton.disabled = currentPage === totalPages;
	}

	function toggleArrowPath(element) {
		if (sortCriteria.order === 'asc') {
			element.innerHTML =
				'<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />'; // Change to ascending arrow
		} else {
			element.innerHTML =
				'<path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" />'; // Change to descending arrow
		}
	}
	// Function to reset arrow paths for all sorting headers
	function resetArrowPaths() {
		sortBronzeSpan.innerHTML =
			'<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />';
		sortSilverSpan.innerHTML =
			'<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />';
		sortGoldSpan.innerHTML =
			'<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />';
	}

	function populateTable(medals) {
		// Get a reference to the table body
		const tableBody = document.querySelector('#medals-body');

		// Calculate the total number of pages based on filtered records
		totalPages = Math.ceil(medals.length / itemsPerPage);

		// Ensure current page is within bounds
		currentPage = Math.min(Math.max(currentPage, 1), totalPages);

		const startIndex = (currentPage - 1) * itemsPerPage;
		const endIndex = Math.min(startIndex + itemsPerPage, medals.length);

		startEntrySpan.innerText = startIndex.toString();
		endEntrySpan.innerText = endIndex.toString();
		totalEntriesSpan.innerText = medals.length.toString();


		const tdClasses =
			'border-b border-slate-700 dark:border-slate-700 p-4 pr-4 xl:text-sm text-xs xl:text-medium text-slate-400 dark:text-slate-400';

		// Clear the table body
		tableBody.innerHTML = '';

		// Loop through the records array
		for (let i = startIndex; i < endIndex; i++) {
			const record = playerMedals[i];
			let row = document.createElement('tr');

			let mapCell = document.createElement('td');
			mapCell.className = tdClasses + " overflow-hidden";
			let mapLink = document.createElement('a');
			mapLink.className = 'hover:text-blue-500 duration-150 cursor-pointer';
			mapLink.href = "map.php?id=" + record.mapId;
			mapLink.innerText = record.map;
			mapCell.appendChild(mapLink);
			row.appendChild(mapCell);


			let bronzeCell = document.createElement('td');
			bronzeCell.className = tdClasses;
			bronzeCell.textContent = record.bronze;
			row.appendChild(bronzeCell);

			let silverCell = document.createElement('td');
			silverCell.className = tdClasses;
			silverCell.textContent = record.silver;
			row.appendChild(silverCell);

			let goldCell = document.createElement('td');
			goldCell.className = tdClasses;
			goldCell.textContent = record.gold;
			row.appendChild(goldCell);

			// Append the row to the table body
			tableBody.appendChild(row);
		}
	}

	function fetchMedals(id) {
		// URL to your PHP script
		const url = 'api/get_player_medals.php';

		// Create an object with the search criteria
		const data = {
			id: id,
		};

		// Send a POST request to the PHP script
		fetch(url, {
				method: 'POST',
				body: JSON.stringify(data),
				headers: {
					'Content-Type': 'application/json'
				}
			})
			.then(response => response.json())
			.then(medals => {
				if (!medals) return;
				playerMedals = medals;
				filteredMedals = medals;
				populateTable(medals);
				updatePagination();
			})
			.catch(error => {
				console.error('Error:', error);
			});
	}

	const params = getUrlParams();
	fetchMedals(params.id);

	function getUrlParams() {
		const searchParams = new URLSearchParams(window.location.search);
		const params = {};

		for (const [key, value] of searchParams.entries()) {
			params[key] = value;
		}

		return params;
	}
}
medalsTable();
</script>

<script>
async function activityChart() {
	const ctx = document.getElementById('activityChart').getContext('2d');
	document.getElementById('activityChart').style.height = '500px'
	const params = getUrlParams();
	const activity = await fetchActivity(params.id); // Fetch the activity data
	const data_dr = prepareData(activity.activity_dr, "Deathrun"); // Prepare data for Chart.js
	const data_bhop = prepareData(activity.activity_bhop, "Bhop"); // Prepare data for Chart.js
	const data_br = prepareData(activity.activity_br, "Brasil Bhop"); // Prepare data for Chart.js
	const data_br_dr = prepareData(activity.activity_br_dr, "Brasil DR"); // Prepare data for Chart.js
	const data = {
		labels: data_dr.labels,
		datasets: [...data_dr.datasets, ...data_bhop.datasets, ...data_br.datasets, ...data_br_dr
			.datasets
		] // Merge datasets
	};

	function getStackColor(stack) {

		const baseColors = {
			'Deathrun': 'rgba(255, 162, 0, 1.0)',
			'Bhop': 'rgba(0, 255, 255, 1.0)',
			'Brasil Bhop': 'rgba(0, 255, 162, 1.0)',
			'Brasil DR': 'rgba(255, 0, 162, 1.0)'
		};

		return baseColors[stack];
	}

	function getStackColorVariation(stack) {
		// Define base colors for each stack
		const baseColors = {
			'Deathrun': {
				r: 255,
				g: 165,
				b: 0
			}, // Bright Orange
			'Bhop': {
				r: 0,
				g: 255,
				b: 255
			}, // Light Cyan (light blue-green)
			'Brasil Bhop': {
				r: 162,
				g: 255,
				b: 0
			},
			'Brasil DR': {
				r: 255,
				g: 0,
				b: 162
			}
		};

		// Get base color
		const baseColor = baseColors[stack] || {
			r: 0,
			g: 0,
			b: 0
		}; // Default to black if stack is not defined

		// Generate color variation
		const variation = (Math.random() - 0.5) * 50; // Adjust variation range as needed
		const r = Math.min(255, Math.max(0, baseColor.r + variation));
		const g = Math.min(255, Math.max(0, baseColor.g + variation));
		const b = Math.min(255, Math.max(0, baseColor.b + variation));

		// Return the generated color with random opacity
		return `rgba(${Math.round(r)}, ${Math.round(g)}, ${Math.round(b)}, ${Math.random() * 0.5 + 0.3})`;
	}

	new Chart(ctx, {
		type: 'bar',
		data: data,
		options: {
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				y: {
					beginAtZero: true,
					stacked: true,
					min: 0,
					title: {
						display: true,
						text: 'Minutes',
						color: 'white'
					},
					ticks: {
						color: 'white'
					}
				},
				x: {
					stacked: true,
					title: {
						display: true,
						text: 'Days',
						color: 'white'
					},
					time: {
						unit: 'day'
					},
					ticks: {
						color: 'white'
					}
				}
			},
			plugins: {
				legend: {
					display: true,
					labels: {
						font: {
							size: 18
						},
						generateLabels: (chart) => {
							const labels = [];
							const stacks = [...new Set(chart.data.datasets.map(ds => ds.stack))];
							stacks.forEach(stack => {
								labels.push({
									text: stack,
									fillStyle: getStackColor(stack),
									hidden: false,
								});
							});
							return labels;
						}
					},
					onClick: (e, legendItem, legend) => {
						const chart = legend.chart;
						const stackId = legendItem.text;

						// Check if any datasets in this stack are visible
						const areAnyDatasetsVisible = chart.data.datasets.some((dataset) => {
							return dataset.stack === stackId && chart.getDatasetMeta(chart
								.data
								.datasets.indexOf(dataset)).hidden === null;
						});

						chart.data.datasets.forEach((dataset, i) => {
							if (dataset.stack === stackId) {
								const meta = chart.getDatasetMeta(i);
								meta.hidden = areAnyDatasetsVisible ? true :
									null; // Toggle visibility
							}
						});

						chart.update();
					}

				},
				tooltip: {
					callbacks: {
						title: function(tooltipItems) {
							const datasetIndex = tooltipItems[0].datasetIndex;
							const dataIndex = tooltipItems[0].dataIndex;
							const sessions = data.datasets[datasetIndex].sessions;
							const stack = data.datasets[datasetIndex].stack;
							const session = sessions[dataIndex];
							if (session) {
								const date = new Date(session.date_join).toISOString().split('T')[
									0];
								return stack + ' - ' + date;
							}
							return '';

						},
						label: function(tooltipItem) {
							const datasetIndex = tooltipItem.datasetIndex;
							const dataIndex = tooltipItem.dataIndex;
							const sessions = data.datasets[datasetIndex].sessions;
							const session = sessions[dataIndex];

							if (session) {
								const date_join = new Date(session.date_join);
								const date_left = session.date_left ? new Date(session.date_left) :
									null;
								const time = session.time;

								return [
									`Start: ${formatTime(date_join)}`,
									`End: ${date_left ? formatTime(date_left) : 'Ongoing'}`,
									`Minutes: ${Math.round(time/60)}`,
								];
							}
							return '';
						}
					}
				}
			}

		},
		plugins: [{
			id: 'customLegendCrossOut',
			beforeDraw: (chart) => {
				const ctx = chart.ctx;
				const legend = chart.legend;
				if (!legend) return;

				legend.legendItems.forEach((legendItem) => {
					const stackId = legendItem.text;
					const meta = chart.getDatasetMeta(chart.data.datasets.findIndex(
						ds => ds.stack === stackId));
					if (meta.hidden) {
						legendItem.fillStyle = 'gray';

					}
				});
			}
		}]
	});



	// Function to prepare data for Chart.js
	function prepareData(dbData, stack) {
		const dates = getPastDays(30); // Get all dates for the past 30 days

		// Initialize data structure
		const days = {};
		dates.forEach(date => {
			days[date] = [];
		});

		// Populate days with data
		if (dbData && dbData.length > 0) {
			dbData.forEach(session => {
				const date = new Date(session.date_join).toISOString().split('T')[0];
				if (days[date] !== undefined) {
					days[date].push(session);
				}
			});
		}

		// Determine the maximum number of sessions in any single day
		const maxSessions = Math.max(...Object.values(days).map(daySessions => daySessions.length), 0);

		// Create datasets
		const datasets = [];
		for (let i = 0; i < maxSessions; i++) {
			const dataset = {
				data: [],
				sessions: [], // Store session details for tooltips
				stack: stack,
				backgroundColor: getStackColorVariation(stack)
			};
			dates.forEach(date => {
				const session = days[date][i] || {};
				dataset.data.push(Math.round(session.time / 60) || 0);
				dataset.sessions.push(session);
			});
			datasets.push(dataset);
		}

		const labels = dates.map(date => {
			const dayDiff = Math.floor((new Date() - new Date(date)) / (1000 * 60 * 60 * 24));
			return dayDiff === 0 ? 'Today' : `${dayDiff}D`;
		});

		return {
			labels: labels,
			datasets: datasets
		};
	}

	// Function to fetch activity data
	async function fetchActivity(id) {
		const url = 'api/get_player_activity.php';

		// Create an object with the search criteria
		const data = {
			id: id
		};

		try {
			const response = await fetch(url, {
				method: 'POST',
				body: JSON.stringify(data),
				headers: {
					'Content-Type': 'application/json'
				}
			});
			const activity = await response.json();
			return activity;
		} catch (error) {
			console.error('Error:', error);
			return []; // Return empty array in case of error
		}
	}

	// Function to get URL parameters
	function getUrlParams() {
		const searchParams = new URLSearchParams(window.location.search);
		const params = {};
		for (const [key, value] of searchParams.entries()) {
			params[key] = value;
		}
		return params;
	}

	// Function to format time to HH:MM
	function formatTime(date) {
		const hours = String(date.getHours()).padStart(2, '0');
		const minutes = String(date.getMinutes()).padStart(2, '0');
		return `${hours}:${minutes}`;
	}

	// Function to generate dates for the past 30 days
	function getPastDays(days) {
		const today = new Date();
		const dates = [];
		for (let i = 0; i < days; i++) {
			const date = new Date(today);
			date.setDate(today.getDate() - i);
			dates.push(date.toISOString().split('T')[0]);
		}
		return dates; // Make the oldest date first
	}

	function getRandomRGBAColor() {
		// Ensure colors are in the range of 200 to 255 to avoid dark colors
		const minColorValue = 155;
		const maxColorValue = 255;

		// Generate random values for Red and Blue components
		// Green component will be minimized or set to zero for a broader blue to red range
		const r = Math.random() < 0.5 ? Math.floor(Math.random() * (maxColorValue - minColorValue +
				1)) +
			minColorValue : 0;
		const g = Math.random() < 0.5 ? Math.floor(Math.random() * (maxColorValue - minColorValue +
				1)) +
			minColorValue : 0;
		const b = Math.random() < 0.5 ? Math.floor(Math.random() * (maxColorValue - minColorValue +
				1)) +
			minColorValue : 0;

		// Generate a random alpha value between 0.5 and 0.8
		const alpha = (Math.random() * 0.3) + 0.5;

		// Return the color in RGBA format
		return `rgba(${r}, ${g}, ${b}, ${alpha.toFixed(2)})`;
	}
}

// Call the function to initialize the chart
activityChart();
</script>




<script src="js/search-player.js"></script>