// Script for search player in navbar
const playerSearchInput = document.getElementById("search-navbar");
const playerSearchInputMobile = document.getElementById("search-navbar-mobile");
const playerSearchList = document.getElementById("searchList");
const playerSearchListMobile = document.getElementById("searchListMobile");

// Event listener for clicking outside the target element
document.addEventListener("click", function (event) {
    if (!playerSearchInput.contains(event.target)) {
        playerSearchList.style.display = 'none';
    }
    else
    {
        playerSearchList.style.display = 'block';
    }
    if (!playerSearchInputMobile.contains(event.target)) {
        playerSearchListMobile.style.display = 'none';
    }
    else
    {
        playerSearchListMobile.style.display = 'block';
    }
});

document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        playerSearchList.style.display = 'none';
        playerSearchListMobile.style.display = 'none';
    }
});

playerSearchInput.addEventListener("input", async function() {
    if(playerSearchInput.value === ''){
        playerSearchList.innerHTML = '';
        return;
    }
    const players = await fetchPlayers(playerSearchInput.value);
    populateList(playerSearchList, players);

});

playerSearchInputMobile.addEventListener("input", async function() {
    if(playerSearchInputMobile.value === ''){
        playerSearchListMobile.innerHTML = '';
        return;
    }
    const players = await fetchPlayers(playerSearchInputMobile.value);
    populateList(playerSearchListMobile, players);
});


function populateList(list, players) {
    // Clear the list body
    list.innerHTML = '';

    if (!players)
        return;

    // Loop through the records array
    players.forEach(function(player) {
        let li = document.createElement('li');
        li.className = 'p-2';

        let a = document.createElement('a');
        a.className = 'cursor-pointer hover:text-blue-500 duration-150 overflow-hidden';
        a.href = "player.php?id=" + player.id;
        a.textContent = player.name;
        li.appendChild(a);

        list.appendChild(li);
    });
}

function fetchPlayers(name) {

    // URL to your PHP script
    const url = 'api/get_players.php';

    // Create an object with the search criteria
    const data = {
        name: name
    };

    // Send a POST request to the PHP script
    return fetch(url, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(players => {
            return players;
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

//  script for mobile menu buttons

const toggleMenuButton = document.getElementById('toggleMenuButton');
const toggleSearchButton = document.getElementById('toggleSearchButton');
const collapseContent = document.getElementById('navbar-menu');

toggleMenuButton.addEventListener('click', () => {
    if (collapseContent.style.display === 'none' || collapseContent.style.display === '') {
        collapseContent.style.display = 'block';
    } else {
        collapseContent.style.display = 'none';
    }
});

toggleSearchButton.addEventListener('click', () => {
    if (collapseContent.style.display === 'none' || collapseContent.style.display === '') {
        collapseContent.style.display = 'block';
    } else {
        collapseContent.style.display = 'none';
    }
});