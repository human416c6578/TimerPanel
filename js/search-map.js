const mapSearchInput = document.getElementById("mapSearch");
const mapList = document.getElementById("mapList");
const mapItems = mapList.getElementsByClassName("map-item");
const limit = 15;
let i = 1;
for (const mapItem of mapItems) {
    if (i > limit)
        break;
    mapItem.style.display = "block";
    i++;
}

mapSearchInput.addEventListener("input", function() {
    i = 0;
    const searchQuery = mapSearchInput.value.toLowerCase();

    for (const mapItem of mapItems) {
        mapItem.style.display = "none";
    }

    for (const mapItem of mapItems) {
        if (i > limit)
            break;
        const mapName = mapItem.textContent.toLowerCase();
        if (mapName.includes(searchQuery)) {
            mapItem.style.display = "block";
            i++;
        }
    }
});