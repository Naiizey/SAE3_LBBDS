            <div class="mentionsLegales" style="display: none;">
                <div class="divFermerCGU">
                    <a href="" class="fermerCGU">
                        <?= file_get_contents(dirname(__DIR__,3)."/public/images/cross.svg") ?>
                    </a>
                </div>
                <h2>Mentions légales</h2>
                <p>Toute personne très peu sympathique tentant de récupérer nos mentions légales se verra dénoncé auprès de Bertrand de Villeneuve et sera notifié oralement de notre ingratitude envers cet acte. Dans le cas échéant, il s'engage à nous verser une compensation monétaire d'une hauteur de 100€ pour le dommage intellectuel et moral effectué.</p>
                <p>Ceci n'est pas une blague.</p>
                <p><a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">Les vraies mentions légales</a></p>
                <p></p>
                <div class="remonterCGU">
                    <?= file_get_contents(dirname(__DIR__,3)."/public/images/fleche_haut.svg") ?>
                </div>
            </div>
            <div>
                <a href="" class="lienCGU"> <!-- Lien mentions légales -->
                    <p>Mentions légales</p> 
                </a>
                <a href="./"> <!-- Lien réseaux sociaux -->
                    <p>Réseaux sociaux</p>
                </a>
                <a href="./"> <!-- Lien aide -->
                    <p>Besoin d'aide ?</p>
                </a>
            </div>
        <footer <?php if(isset($role)):?>
                <?php if($role == "admin"):?>
                    <?= "class=footerAdmin" ?>
                <?php endif;?>
            <?php endif; ?>
            <?php if(isset($estVendeur)):?>
                <?php if($estVendeur == true):?>
                    <?= "class=footerVendeur" ?>
                <?php endif;?>
            <?php endif; ?>>            
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
                    <a class="lienConnexion" href="<?= ((session()->has("numero")) ? base_url()."/espaceClient" : base_url()."/connexion") ?>">
                        <?php include(dirname(__DIR__,3)."/public/images/header/profil.svg")?>
                    </a>
                    <?php if (session()->has("numero")): ?>
                        <div class="divHoverConnexion divConnected">
                            <p class="pNom">Bonjour <?= (session()->get("nom")) ?></p>
                            <a href="<?= base_url()."/espaceClient"?>"><p>Mon profil</p></a>
                            <a href="<?= base_url()."/destroy"?>"><p>Se déconnecter</p></a>
                        </div>
                    <?php else: ?>
                        <div class="divHoverConnexion divNotConnected">
                            <a href="<?= base_url()."/connexion"?>"><p>Se connecter</p></a>
                            <a href="<?= base_url()."/inscription"?>"><p>S'inscrire</p></a>
                        </div>
                    <?php endif; ?>
                    </li>
                    <li>
                        <a href="./"> <!-- contact -->
                            <?php include("./images/header/contact.svg")?>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url() ?>/panier"> <!-- panier -->
                            <?php include("./images/header/panier.svg")?>
                        </a>
                    </li>
                    <li>
                        <div></div>
                        <div></div>
                        <div></div>
                    </li>
                </ul>
            </div>
        </footer>
        <script src="<?= base_url() ?>/js/script.js"></script>
    </body>
</html>
<script>
    footer();
    cgu();
    menuCredit();
</script>
