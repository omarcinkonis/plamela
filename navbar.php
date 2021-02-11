<nav class="navbar navbar-expand-lg navbar-light" id="navigacija">
    <!-- hamburger (side menu) -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#hamburgeris" aria-controls="hamburgeris" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- puslapio ikona (viršuj kairėje) -->
    <a class="navbar-brand d-none d-lg-block" href="../index.php">
        <img src="../img/p.png" height="50" class="d-inline-block align-top" alt="">
    </a>

    <!-- paieškos langelis: mobili versija -->
    <div id="paieska-mobile" class="ml-auto">
        <div class="md-form mt-0 d-block d-lg-none">
            <input class="form-control" type="text" placeholder="Ieškoti" aria-label="Search" onkeypress="ieskoti(event, this.value)">
        </div>
    </div>

    <!-- kairė pusė (desktop) -->
    <div class="collapse navbar-collapse">
        <div class="navbar-nav text-center">
            <a class="nav-item nav-link" href="../index.php">Pagrindinis</a>
            <a class="nav-item nav-link" href="../visireceptai.php">Receptai</a>
            <a class="nav-item nav-link d-none" href="../valgiarastis.php">Valgiaraštis</a>
            <a class="nav-item nav-link" href="../parduotuve.php">Maisto prekės</a>
            <a class="nav-item nav-link" href="../saldytuvas.php">Virtualus šaldytuvas</a>
        </div>	
    </div>

    <!-- paieškos langelis: desktop versija -->
    <div class="md-form mt-0 d-none d-lg-block">
        <input class="form-control" type="text" placeholder="Ieškoti" aria-label="Search" onkeypress="ieskoti(event, this.value)">
    </div>
    
    <!-- dešinė pusė -->
    <img class="d-block d-lg-none ml-auto mr-3" src="../img/search.svg" onload="displayNone()" onclick="rodytiPaieska()" height="30">
    <div class="nav navbar-nav navbar-right d-inline-block">
        <div class="dropdown">
            <a href="#" id="naudotojas" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="../img/user.svg">
            </a>
            <div class="dropdown-menu dropdown-menu-right mx-auto" style="position:absolute" aria-labelledby="naudotojas">
                <?php 
                    if (isset($_SESSION['username'])) {
                        echo '<div class="text-center">Prisijungęs vartotojas: ' . $_SESSION['username']; 
                        echo '<br><a href="atsijungti.php" class="btn btn-secondary btn-sm" role="button" style="margin-top:10px;">Atsijungti</a></div>';
                    }
                    else {
                        echo '
                        <div class="text-center mb-2">
                            <div id="radio-buttons" class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary active">
                                    <input onclick="prisijungimoForma()" type="radio" name="options" id="prisijungimas" autocomplete="off" checked> Prisijungti
                                </label>
                                <label class="btn btn-secondary">
                                    <input onclick="registracijosForma()" type="radio" name="options" id="registracija" autocomplete="off"> Registruotis
                                </label>
                            </div>
                        </div>
                        
                        <div id="login">
                            <form action="prisijungimas.php" autocomplete="off" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="Slapyvardis" placeholder="Slapyvardis" pattern="[^\s][A-Za-z0-9-_.ĄČĘĖĮŠŲŪŽąčęėįšųūž]{3,20}" title="Slapyvardis, su kuriuo užsiregistravote." required="required">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="Slaptazodis" placeholder="Slaptažodis" minlength="8" title="Slaptažodis, su kuriuo užsiregistravote." required="required">
                                </div>
                                <input type="submit" class="btn btn-primary btn-block" value="Prisijungti">
                                <div class="text-center mt-2">
                                    <a href="#">Pamiršau slaptažodį</a>
                                </div>
                            </form>
                        </div>

                        <div id="registration" style="display:none;">
                            <form action="registracija.php" autocomplete="off" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="Slapyvardis" placeholder="Slapyvardis" pattern="[^\s][A-Za-z0-9-_.ĄČĘĖĮŠŲŪŽąčęėįšųūž]{3,20}" title="Reikalingas prisijungimui. Slapyvardį matys kiti vartotojai prie jūsų komentarų. Nuo 4 iki 20 raidžių, skaičių, brūkšnių, taškų (A-Ž, a-ž, 0-9, -, _, .). Be tarpų." required="required">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="Pastas" placeholder="Elektroninis paštas" pattern="[A-Za-z0-9.]+@[a-z0-9.-]+\.[a-z]{2,}" title="Paštas privalo būti užrašytas taisyklingai." required="required">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="Slaptazodis" placeholder="Slaptažodis" minlength="8" maxlength="255" title="Slaptažodį privalo sudaryti nuo 8 iki 255 simbolių" required="required">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="Slaptazodis2" placeholder="Pakartokite slaptažodį" minlength="8" maxlength="255" title="Slaptažodžiai privalo sutapti" oninput="check(this)" required="required">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="Vardas" placeholder="Vardas ir pavardė" pattern="[A-Za-zĄČĘĖĮŠŲŪŽąčęėįšųūž]+ [A-Za-zĄČĘĖĮŠŲŪŽąčęėįšųūž]{1,100}" title="Jūsų vardas ir pavardė (reikalinga prekių pristatymui). Gali sudaryti raidės (A-Ž, a-ž,), tarpai." required="required">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="Adresas" placeholder="Prekių pristatymo adresas" pattern="[A-Za-z0-9ĄČĘĖĮŠŲŪŽąčęėįšųūž. -]{1,100}" title="Jūsų adresas (reikalingas prekių pristatymui)." required="required">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="Numeris" placeholder="Telefono numeris" pattern="[0-9+]{4,12}" title="Telefono numeris, kurį nurodysime kurjeriui." required="required">
                                </div>
                                <input type="submit" class="btn btn-primary btn-block" value="Registruotis">
                            </form>
                        </div>
                        ';
                    }
                ?>
            </div>
        </div>

        <div class="dropdown">
            <a href="#" id="krepselis" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="../img/shopping-bag.svg">
            </a>
            <div id="krepselis-menu" style="position:absolute" class="dropdown-menu dropdown-menu-right text-center" aria-labelledby="krepselis">
                <span id="krepselio-turinys">Jūsų krepšelis yra tuščias.</span>
                <form action="uzsakymas.php" method="post">
                    <input type="submit" class="btn btn-primary btn-block" value="Pirkti">
                </form>
            </div>
        </div>
    </div>

    <!-- hamburgerio turinys (mobile) -->
    <div class="collapse navbar-collapse" id="hamburgeris">
        <div class="navbar-nav text-center" id="hamburgerio-tekstas">
            <a class="nav-item nav-link" href="../index.php">
                <img src="../img/p.png" height="50">
            </a>
            <a class="nav-item nav-link" href="../index.php">Pagrindinis</a>
            <a class="nav-item nav-link" href="../visireceptai.php">Receptai</a>
            <a class="nav-item nav-link" href="../valgiarastis.php">Valgiaraštis</a>
            <a class="nav-item nav-link" href="../parduotuve.php">Maisto prekės</a>
            <a class="nav-item nav-link" href="../saldytuvas.php">Virtualus šaldytuvas</a>
        </div>	
    </div>
</nav>

<script>
    // Funkcija, kuri vykdo paiešką tarp produktų
    function ieskoti(evt,input) {
        if (evt.key === 'Enter') {
            if (input == "") {
                window.location.href = "/parduotuve.php";
            }
            else {
                window.location.href = "/parduotuve.php?raktazodis=" + input;
            }
        }
    }

    // Kai display: none parametras nurodytas tik CSS faile, rodytiPaieska() funkcija pirmu paspaudimu neveikia. Kad ji veiktų, pakrovus #paieska-mobile iškviečiama funkcija displayNone()
    function displayNone() {
        var x = document.getElementById("paieska-mobile");
        x.style.display = "none";
    }

    // Rodo arba slepia paiešką mobile versijoje (priklausomai nuo to, ar paieška atidaryta, ar ne); slepia arba rodo puslapio logo
    function rodytiPaieska() {
        var x = document.getElementById("paieska-mobile");
        var y = document.getElementsByClassName("navbar-brand");
        if (x.style.display == "none") {
            x.style.display = "block";
            y[0].style.display = "none";
        }
        else {
            x.style.display = "none";
            y[0].style.display = "block";
        }
    }

    // Sukuriame funkciją, kuri nustato aktyvų elementą
    function changeActive(activeBtn) {
        // Pasirenkame navigaciją
        let btnContainer = document.getElementById("navigacija");

        // Pasirenkame visus mygtukus navigacijoje, kurie gali būti aktyvūs
        let btns = btnContainer.getElementsByClassName("nav-item");

        // Einame per visus pasirinktus mygtukus. Suradę reikiamą mygtuką, padarome jį aktyvų
        for (let i = 0; i < btns.length; i++) {
            if (btns[i].innerHTML == activeBtn) {
                btns[i].className += " active";
            }
        } 
    }

    // Neleidžia uždaryti krepšelio, kai spaudinėjamas jo turinys
    $('#krepselis-menu').click(function(e) {
        e.stopPropagation();
    });

    // Koreguoja, ar vartotojas mato prisijungimą, ar registraciją
    function prisijungimoForma() {
        loginForm = document.getElementById("login");
        registationForm = document.getElementById("registration");
        loginForm.style.display = "block";
        registationForm.style.display = "none";
        eventFire(document.getElementById('naudotojas'), 'click');
    }

    function registracijosForma() {
        loginForm = document.getElementById("login");
        registationForm = document.getElementById("registration");
        loginForm.style.display = "none";
        registationForm.style.display = "block";
        eventFire(document.getElementById('naudotojas'), 'click');
    }

    // Ši funkcija simuliuoja paspaudimą ir taip atidaro login/registracijos formas, kai jos automatiškai uždaromos dėl radio mygtukų paspaudimo
    // Anksčiau krepšeliui naudota funkcija sugadina radio mygtukų veikimą, tad taikomas kitas sprendimas
    function eventFire(el, etype){
        if (el.fireEvent) {
            el.fireEvent('on' + etype);
        }
        else {
            var evObj = document.createEvent('Events');
            evObj.initEvent(etype, true, false);
            el.dispatchEvent(evObj);
        }
    }

    // Tikrina, ar sutampa abu vartotojo įvesti slaptažodžiai registracijos formoje
    function check(input) {
        if (input.value != document.getElementsByName('Slaptazodis')[1].value) {
            input.setCustomValidity('Slaptažodžiai privalo sutapti.');
        } else {
            // vartotojo įvestis teisinga, grąžinama originali žinutė
            input.setCustomValidity('');
        }
    }
</script>