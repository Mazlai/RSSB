<?php

    echo('<header>

        <div id="show-sidebar">
            <i class="bx bx-chevron-left"></i>
        </div>

        <div id="sidebar">

            <div id="logo-details">
                <a href="../"><img id="menu-logo" src="../include/images/site/logo_rssb.jpg" alt="Logo RSSB"></a>
            </div>

            <ul class="nav-links">

                <li class="main-li">
                    <a class="menu-items" href="../">
                        <i class="sizebx bx bxs-circle"></i>
                        <span class="link-name">Accueil</span>
                    </a>
                </li>

                <li class="main-li">

                    <div class="icon-link">
                        <a class="menu-items" href="association.php">
                            <i class="sizebx bx bxs-circle"></i>
                            <span class="link-name">Notre association</span>
                        </a>
                        <i class="bx bx-down-arrow-alt arrow"></i>
                    </div>
                
                    <ul class="submenu">
                        <li class="submain-li"><a class="submenu-items" href="organigramme.php"><i class="bx bxs-circle"></i><span class="link-name">Organigramme</span></a></li>
                        <li class="submain-li"><a class="submenu-items" href="docs-permanents.php"><i class="bx bxs-circle"></i><span class="link-name">Documents permanents</span></a></li>
                        <li class="submain-li"><a class="submenu-items" href="partenariats.php"><i class="bx bxs-circle"></i><span class="link-name">Partenariats</span></a></li>
                    </ul>
                
                </li>

                <li class="main-li">

                    <div class="icon-link">
                        <a class="menu-items" href="activites.php">
                            <i class="sizebx bx bxs-circle"></i>
                            <span class="link-name">Nos activités</span>
                        </a>
                        <i class="bx bx-down-arrow-alt arrow"></i>
                    </div>
                
                    <ul class="submenu">
                        <li class="submain-li"><a class="submenu-items" href="personnes-agees.php"><i class="bx bxs-circle"></i><span class="link-name">Personnes âgées</span></a></li>
                        <li class="submain-li"><a class="submenu-items" href="adultes-familles.php"><i class="bx bxs-circle"></i><span class="link-name">Adultes et familles</span></a></li>
                        <li class="submain-li"><a class="submenu-items" href="jeunes.php"><i class="bx bxs-circle"></i><span class="link-name">Jeunes</span></a></li>
                    </ul>
                
                </li>
                    
                <li class="main-li">
                    <a class="menu-items" href="localisation.php">
                        <i class="sizebx bx bxs-circle"></i>
                        <span class="link-name">Localisation et accès</span>
                    </a>
                </li>

                <li class="main-li">

                    <div class="icon-link">
                        <a class="menu-items" href="benevoles.php">
                            <i class="sizebx bx bxs-circle"></i>
                            <span class="link-name">Bénévoles</span>
                        </a>
                        <i class="bx bx-down-arrow-alt arrow"></i>
                    </div>
                
                    <ul class="submenu">
                        <li class="submain-li"><a class="submenu-items" href="formations.php"><i class="bx bxs-circle"></i><span class="link-name">Formations</span></a></li>
                    </ul>
                
                </li>

                <li class="main-li">
                    <a class="menu-items" href="imagesrssb.php">
                        <i class="sizebx bx bxs-circle"></i>
                        <span class="link-name">RSSB en images</span>
                    </a>
                </li>');

                if(!isset($_SESSION['idMembre'])) {
                    echo('<div id="intranet-container-tel">
                        <input type="button" id="intranet-tel" onclick="location.href=\'intranet.php\';" value="Intranet">
                    </div>');
                } else {
                    echo('<div id="containerCompte-tel" style="cursor: pointer;" onclick="location.href=\'compte.php\'">
                        <div id="subcontainer-tel">
                            <img id="imageCompte" src="./include/images/site/customer.png" alt="customer">
                            <p id="headerTextCompte">Bonjour, vous êtes sur le réseau.</p>
                        </div>
                    </div>');
                }

            echo('</ul>
            
        </div>

        <div id="main">

            <div class="main-info">
                <h1 id="main-title"><font color="#CC1C35">Réseau </font><font color="#F25929">Social </font><font color="#F7931E">Solidaire </font><font color="#838383">de Blagnac</font></h1>');

                if(!isset($_SESSION['idMembre'])) {
                    echo('<input type="button" id="intranet" onclick="location.href=\'intranet.php\';" value="Intranet">');
                } else {
                    echo('<div id="containerCompte" style="cursor: pointer;" onclick="location.href=\'compte.php\'">
                        <img id="imageCompte" src="./include/images/site/customer.png" alt="customer">
                        <p id="headerTextCompte">Bonjour, vous êtes sur le réseau.</p>
                    </div>');
                }

            echo('</div>

            <div id="top-circles">
                <div id="top-red-circle"></div>
                <div id="top-orangered-circle"></div>
                <div id="top-orange-circle"></div>
                <div id="top-grey-circle"></div>
            </div>    

        </div>

    </header>

    <script>
        let arrow = document.querySelectorAll(".arrow");

        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e) => {
                let arrowParent = e.target.parentElement.parentElement;
                arrowParent.classList.toggle("showMenu");
            });
        }
            
        document.getElementById("show-sidebar").addEventListener("click", function() {
            this.classList.toggle("arrow-left");
            var sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("show-menu");
            if (sidebar.classList.contains("show-menu")) {
                sidebar.style.marginLeft = "0px"; // Afficher le menu en décalant vers la gauche
                this.style.marginLeft = "200px";
            } else {
                sidebar.style.marginLeft = "-200px"; // Cacher le menu en décalant hors de l\'écran
                this.style.marginLeft = "0";
            }
        });
            
    </script>');     

?>