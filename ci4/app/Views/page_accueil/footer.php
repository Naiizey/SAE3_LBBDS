            <div class="mentionsLegales" style="display: none;">
                <div class="divFermerCGU">
                    <a href="" class="fermerCGU">
                        <?= file_get_contents(dirname(__DIR__,3)."/public/images/cross.svg") ?>
                    </a>
                </div>
                <h2>Conditions générales d’utilisation</h2>
                <p>Bienvenue sur Alizon.bzh.</p>
                <p>Alizon vous offre la possibilité de visualiser et rechercher dans un catalogue de produits proposé par l’association de marchands de la COBREC, qui sont les propriétaires du site. En tant que client de la COBREC vous pouvez en plus, acheter des produits et vous les faire livrer et facturer aux adresses que vous avez spécifiées.</p>
                <p>Vous pouvez aussi commenter et laisser une note sur les produits que vous avez utilisés.</p>
                <p>Pour ce qui est du vendeur appartenant à la COP de la COBREC, il a la possibilité de poster ses produits, les mettre en réductions, de les mettre en avant et aussi visualiser les stocks de chaque produit.</p>
                <p>En utilisant la plateforme, vous reconnaissez avoir lu, compris et accepté l’entièreté et sans aucunes réserves les conditions générales d’utilisation et de ventes présentées ci-dessous.</p>
                <h2>Conditions générales d’utilisation</h2>
                <p>Bienvenue sur Alizon.bzh.</p>
                <p>Alizon vous offre la possibilité de visualiser et rechercher dans un catalogue de produits proposé par l’association de marchands de la COBREC, qui sont les propriétaires du site. En tant que client de la COBREC vous pouvez en plus, acheter des produits et vous les faire livrer et facturer aux adresses que vous avez spécifiées.</p>
                <p>Vous pouvez aussi commenter et laisser une note sur les produits que vous avez utilisés.</p>
                <p>Pour ce qui est du vendeur appartenant à la COP de la COBREC, il a la possibilité de poster ses produits, les mettre en réductions, de les mettre en avant et aussi visualiser les stocks de chaque produit.</p>
                <p>En utilisant la plateforme, vous reconnaissez avoir lu, compris et accepté l’entièreté et sans aucunes réserves les conditions générales d’utilisation et de ventes présentées ci-dessous.</p>
                <h2>Conditions générales d’utilisation</h2>
                <p>Bienvenue sur Alizon.bzh.</p>
                <p>Alizon vous offre la possibilité de visualiser et rechercher dans un catalogue de produits proposé par l’association de marchands de la COBREC, qui sont les propriétaires du site. En tant que client de la COBREC vous pouvez en plus, acheter des produits et vous les faire livrer et facturer aux adresses que vous avez spécifiées.</p>
                <p>Vous pouvez aussi commenter et laisser une note sur les produits que vous avez utilisés.</p>
                <p>Pour ce qui est du vendeur appartenant à la COP de la COBREC, il a la possibilité de poster ses produits, les mettre en réductions, de les mettre en avant et aussi visualiser les stocks de chaque produit.</p>
                <p>En utilisant la plateforme, vous reconnaissez avoir lu, compris et accepté l’entièreté et sans aucunes réserves les conditions générales d’utilisation et de ventes présentées ci-dessous.</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nemo, eaque distinctio tempora reprehenderit voluptatum necessitatibus impedit minima! Incidunt molestias delectus, omnis officiis dolore minima quod aspernatur cupiditate dicta molestiae cum.</p>
                <div class="remonterCGU">
                    <?= file_get_contents(dirname(__DIR__,3)."/public/images/fleche_haut.svg") ?>
                </div>
            </div>
        <footer>            
            <div class="pc">
                <a href="" class="lienCGU"> <!-- Lien mentions légales -->
                    <p>Mentions légales</p>
                </a>
                <a href=""> <!-- Lien contacts -->
                    <p>Contacts</p>
                </a>
                <a href=""> <!-- Lien réseaux sociaux -->
                    <p>Réseaux sociaux</p>
                </a>
                <a href=""> <!-- Lien aide -->
                    <p>Besoin d'aide ?</p>
                </a>
            </div>
            <p>&copy; 2022 Alizon.bzh et ses affiliés</p>
            <div class="mobile">
                <ul>
                    <li>
                        <a href="./"> <!-- profile -->
                            <?php include("./images/header/profil.svg")?>
                        </a>
                    </li>
                    <li>
                        <a href="./"> <!-- contact -->
                            <?php include("./images/header/contact.svg")?>
                        </a>
                    </li>
                    <li>
                        <a href="./panier"> <!-- panier -->
                            <?php include("./images/header/panier.svg")?>
                        </a>
                    </li>
                    <li>
                        <div></div>
                        <div></div>
                        <div></div>
                    </li>
                    <div>
                        <a> <!-- Lien mentions légales -->
                            <p>Mentions légales</p> 
                        </a>
                        <a href="./"> <!-- Lien réseaux sociaux -->
                            <p>Réseaux sociaux</p>
                        </a>
                        <a href="./"> <!-- Lien aide -->
                            <p>Besoin d'aide ?</p>
                        </a>
                    </div>
                </ul>
            </div>
        </footer>
        <script src="<?= base_url() ?>/js/script.js"></script>
    </body>
</html>
<script>
    footer();
    cgu();
</script>