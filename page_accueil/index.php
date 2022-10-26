<!-- faire liens -->
<!--dans le imput de recherche : onkeyup="fonction de recherche en php"-->
<!-- ajuster les logos -->
<?php require("header.php"); ?>
            <nav>
                <ul>
                    <li class="liCategorie">
                        <a class="categorie" href="">Catégorie 1</a>
                    </li>
                    <li class="liCategorie">
                        <a class="categorie" href="">Catégorie 2</a>
                    </li>
                    <li class="liCategorie">
                        <a class="categorie" href="">Catégorie 3</a>
                    </li>
                    <li class="liCategorie">
                        <a class="categorie" href="">Catégorie 4</a>
                    </li>
                    <li class="liCategorie">
                        <a class="categorie" href="">Catégorie 5</a>
                    </li>
                </ul>
            </nav>
        </header>
        <main>

            <section id="carousel-container">
                <ul id="carousel"> <!-- Menu ./images -->
                    <a href="" class="slide">
                        <img src="./images/art (1).jpg" alt="article 1" title="Article 1">
                    </a>
                    <a href="" class="slide">
                        <img src="./images/art (2).jpg" alt="article 2" title="Article 2">
                    </a>
                    <a href="" class="slide">
                        <img src="./images/art (3).jpg" alt="article 3" title="Article 3">
                    </a>
                    <img src="./images/fleche_gauche.png" alt="flèche gauche" class="btn btn-prev">
                    <img src="./images/fleche_droite.png" alt="flèche droite" class="btn btn-suiv">
                </ul>
            </section>
        </main>
<?php require("footer.php"); ?>