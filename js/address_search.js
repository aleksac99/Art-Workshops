const input = document.querySelector('input[id="floatingAddress"]');

input.addEventListener('input', async () => {
    setTimeout(async () => {
        
        // Address Search Provider
        const provider = new GeoSearch.OpenStreetMapProvider({
            params: {
            limit: 5,
            },
        },);

        // Form elements
        var d = document.querySelector('.address-search-result');
        
        const results = await provider.search({ query: input.value });
        var r = [];
        for(let i=0 ; i<results.length ; i++) {
            r.push("<div onclick=\"addToBar('"+results[i].label+"')\">" + results[i].label + "</div>");
        }
    d.innerHTML = r.join("<br>");
    }, 100); // 100ms
});

// Add to search bar and clear suggestions
function addToBar(s) {

    var input = document.querySelector('input[id="floatingAddress"]');
    input.value = s;
    var d = document.querySelector('.address-search-result');
    d.innerHTML="";
}