function checkNumFiles() {
    
    var f = document.querySelector('input[id="imageGallery"]');

    if (f.files.length>5) {
        alert("Izabrano više od 5 slika!");
        f.value=null;
    }
}