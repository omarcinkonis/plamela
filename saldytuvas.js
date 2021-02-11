// https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API

// prijungiamas puslapyje esantis canvas elementas
let canvas = document.getElementById('saldytuvas');
let ctx = canvas.getContext('2d');

// rekursinė funkcija, kuri krauna visas reikiamas nuotraukas ir tikrina, ar jos pasikrovė
function loadImages(loadingQueue) {
    // sukuriam kintamąjį img, kurio tipas yra nuotrauka
    let img = new Image();

    // kiekvienoje ciklo iteracijoje priskiriam kintamajam img pirmą lokaciją iš apibrėžto nuotraukų lokacijų sąrašo (eilės)
    img.src = loadingQueue[0];

    // kai img nuotrauka pakraunama, priskiriam ją sekančiai laisvai vektoriaus images vietai
    img.onload = function() {
        images.push(img); // push() prideda elementą į vektoriaus images galą (išsaugo nuotrauką pakrautų nuotraukų vektoriuje)
        loadingQueue.shift(); // shift() pašalina pirmą vektoriaus loadingQueue elementą, taip leidžia funkcijai prasidėjus iš naujo pereiti prie naujos nuotraukos krovimo
        // alert('Nuotrauka pakrauta. Liko pakrauti nuotraukų: ' + loadingQueue.length); // testavimui
        if (loadingQueue.length > 0) loadImages(loadingQueue); // jei eilėje dar liko nuotraukų, kviesti funkciją darkart
        else {
            // alert('Piešiamas šaldytuvas'); // testavimui
            displayFridge(); // kai eilė tuščia, t.y. visos nuotraukos pakrautos, piešti šaldytuvą
        }
    }
}

// šiame vektoriuje bus saugomos pakrautos nuotraukos
var images = [];

// sudarome norimų pakrauti nuotraukų sąrašą (eilę) ir pradedame nuotraukų krovimą
var loadingQueue = ['img/saldytuvasTrans.png'/*, 'img/P.png'*/];
loadImages(loadingQueue);
// NEKVIESTI loadImages() antrą kartą, nes ši funkcija asinchroninė. Be papildomo kodo, bus problemų (o be to, kviesti antrą kartą nėra prasmės, geriausia tiesiog pildyti loadingQueue)
// bus kaip saugumo sumetimas, jei vartotojas norės pakrauti nuotraukas iš serverio, kurių jis neturėtų matyti, tai jam teks gerokai pasistengti


// funkcija, kuri piešia šaldytuvą ir įgalina jo funkcijas - iškviečiama, kai pakraunamos visos nuotraukos
function displayFridge () {
    ctx.drawImage(images[0], 0, 0); // piešiam šaldytuvą
    // ctx.fillRect(0, 0, 100, 100); // testas
    // ctx.drawImage(images[1], 0, 0); // testavimui
    
    
    class Button {
        constructor(x, y, text) {
            // apibrėžiam mygtuko koordinates
            this.left = x;
            this.top = y;
            this.right = x + 254;
            this.bottom = y + 104;

            // kas bus parašyta mygtuko viduje
            this.text = text;

            // mygtuko būsena: -1 reiškia dar nebuvo aktyvuotas, 1 reiškia aktyvuotas, 0 reiškia, kad buvo aktyvuotas, bet po to išjungtas
            this.activated = 0; // buvo -1, dabar pakeista nes nebesaugomi pakrauti produktai

            // čia bus saugomi pakrauti produktai
            // this.products = 0;

            // atvaizduoja mygtuką (jei yra poreikis, galima į loadingQueue įdėti sprite ir naudoti custom mygtuko paveikslėlį vietoje stačiakampio)
            // ctx.fillStyle = "rgba(254, 197, 53, 0.73)";
            ctx.fillStyle = "rgba(245, 245, 245, 1)"; // mygtuko spalva RGBA formatu (po testavimo matyti, kad alpha geriau nenaudoti - atsiranda glitch'ai)
            ctx.fillRect(x, y, 254, 104); // kur atvaizduoti ir kokio dydžio

            // atvaizduoja mygtuko tekstą
            ctx.fillStyle = "rgba(0, 0, 0, 1)";
            ctx.font = "18px Arial";
            ctx.fillText(this.text, x+4, y+18); 

            console.log("Sukurtas mygtukas(-ai)"); // testavimui
        }

        checkClicked() {
            // kai paspaudžiama pelytė, tikrinam, ar pelytė yra ant mygtuko; čia galima vykdyti funkcijas, kurios universaliai tinka visiems mygtukams
            if (this.left <= mouseX && mouseX <= this.right && this.top <= mouseY && mouseY <= this.bottom) {
                // keičia mygtuko būseną į 0 arba 1, pakeičia mygtuko foną taip, kad fonas atitiktų mygtuko būseną
                if (this.activated/* == 1*/) {
                    this.swapBackground(this, "rgba(245, 245, 245, 1)");
                    this.activated = 0;
                    console.log("Mygtukas deaktyvuotas");
                }
                
                else {
                    this.swapBackground(this, "rgba(254, 197, 53, 1)");
                    this.activated = 1;
                    console.log("Mygtukas aktyvuotas");
                }

                
                // testavimui
                console.log("Paspaustas mygtukas: " + this.text);

                // nurodo, kad pasikeitė mygtuko būsena (mygtukas paspaustas)
                return true;
            }
        }

        swapBackground(btn, color) {
            // atvaizduoja mygtuką
            ctx.fillStyle = color; // mygtuko spalva nurodoma per funkcijos argumentą pasirinktu formatu
            ctx.fillRect(btn.left, btn.top, 254, 104); // kur atvaizduoti ir kokio dydžio

            // atvaizduoja mygtuko tekstą
            ctx.fillStyle = "rgba(0, 0, 0, 1)";
            ctx.font = "18px Arial";
            ctx.fillText(btn.text, btn.left+4, btn.top+18); 
        }
    }
    
    let btn = [];
    btn[0] = new Button(284, 74, "Duonos gaminiai"); // x ir y koordinatės, mygtuko tekstsa
    btn[1] = new Button(284, 232, "Mėsa ir žuvis");
    btn[2] = new Button(284, 390, "Pieno produktai ir kiaušiniai");
    btn[3] = new Button(284, 548, "Daržovės ir vaisiai");
    btn[4] = new Button(284, 706, "Šaldytas maistas");

    // pelytės funkcionalumas:
    // kintamieji, skirti saugoti pelytės koordinatėms
    let mouseX = 0;
    let mouseY = 0; 
    
    // sekam, ar paspausta pelytė
    document.addEventListener("click", mouseClicked, false);

    // kai paspausta pelytė...
    function mouseClicked(e) { // e = event
        // globalias koordinates paverčiame canvas koordinatėmis:
        mouseX = e.pageX - canvas.offsetLeft; // atimame kiek canvas yra nutolęs nuo puslapio kairio krašto
        mouseY = e.pageY - canvas.offsetTop; // atimame kiek canvas yra nutolęs nuo puslapio viršaus
        console.log("Užfiksuotas pelytės paspaudimas"); // testavimui

        // praeina pro visų mygtukų koordinates ir patikrina, ar užregistruotas paspaudimas kurio nors iš jų zonoje. 
        for (let i = 0; i < btn.length; i++) { // praeina pro visus mygtukus
            if (btn[i].checkClicked()) { // patikrina, ar užregistruotas paspaudimas kurio nors iš mygtukų zonoje (ar pasikeitė kurio nors mygtuko būsena)
                // jei pasikeitė kurio nors mygtuko būsena, krauna naują šaldytuvo turinį pagal tai, kurie mygtukai paspausti
                makeRequest(); // AJAX
            }
        }
    }
    
    // sudaro aktyvuotų mygtukų sąrašą
    function logActivated() {
        var log = '?categories=';
        for (let i = 0; i < btn.length; i++) { // praeina pro visus mygtukus
            if (btn[i].activated) { // patikrina, ar mygtukas aktyvuotas; jei taip, prideda jį prie aktyvuotų sąrašo
                log = log + i + ',';
            }
        }
        log = log.substring(0, log.length - 1); // grąžina log reikšmę nuo pirmo iki priešpaskutinio simbolio (panaikina paskutinį kablelį)
        //alert(log);
        return log;
    }

    const resultArea = document.getElementById("fridgeContent");

    function makeRequest() {
        httpRequest = new XMLHttpRequest();
        if (!httpRequest) {
            resultArea.innerHTML = 'Klaida! Nepavyko suformuoti užklausos. Perkraukite puslapį. Jei problema tęsiasi, susisiekite su IT pagalba.';
            return false;
        }
        // httpRequest.onreadystatechange atributas prilyginamas funkcijai makeChanges, todėl kiekvieną kartą jam suveikiant, suveikia ir makeChanges()
        httpRequest.onreadystatechange = makeChanges; // kai daromas reference į funkciją, o ne iškvietimas, skliaustai po funkcijos pavadinimo nerašomi
        let page = "saldytuvoTurinys.php";
        let variables = logActivated(); // aktyvuotų mygtukų sąrašas
        
        let url = page + variables;
        // alert(url);
        httpRequest.open('GET', url); // argumentai paduodami per link su kableliais, po to per PHP daroma explode
        httpRequest.send();
    }

    function makeChanges() {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                resultArea.innerHTML = httpRequest.responseText;
            }
            else {
                resultArea.innerHTML = 'Klaida! Nepavyko įvykdyti užklausos. Patikrinkite, ar nedingo internetas, perkraukite puslapį. Jei problema tęsiasi, susisiekite su IT pagalba.';
            }
        }
    }

}