<!-- faire liens -->
<!--dans le imput de recherche : onkeyup="fonction de recherche en js"-->
<!-- ajuster les logos -->
<?php require("header.php"); ?>
            <nav>
                <ul>
                    <li>
                        <a class="categorie" href="">Catégorie 1</a>
                    </li>
                    <li>
                        <a class="categorie" href="">Catégorie 2</a>
                    </li>
                    <li>
                        <a class="categorie" href="">Catégorie 3</a>
                    </li>
                    <li>
                        <a class="categorie" href="">Catégorie 4</a>
                    </li>
                    <li>
                        <a class="categorie" href="">Catégorie 5</a>
                    </li>
                </ul>
            </nav>
        </header>
        <main>
            <!-- Articles vedette, ./images qui défilent -->
            <div id="defiler"> <!-- Menu ./images -->
                <img src="./images/fleche_gauche.png" alt="flèche gauche">
                <a href="">
                    <img src="./images/art1.png" alt="article 1" title="Article 1">
                </a>
                <a href="">
                    <img src="./images/art2.png" alt="article 2" title="Article 2">
                </a>
                <a href="">
                    <img src="./images/art3.png" alt="article 3" title="Article 3">
                </a>
                <a href="">
                    <img src="./images/art4.png" alt="article 4" title="Article 4">
                </a>
                <img src="./images/fleche_droite.png" alt="flèche droite">
            </div>
        </main>
        <?php require("footer.php"); ?>
    </body>
</html>