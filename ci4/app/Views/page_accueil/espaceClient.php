<?php require("header.php"); ?>
<main class="mainEspaceCli">
    <?php echo file_get_contents(dirname(__DIR__,3)."/public/images/header/profil.svg");?>
    <h2>Bonjour <?php echo $pseudo?>!</h2>
    <div class="divCredit divEspaceCli">
        <section class="sectionCredit">
            <form action="<?= base_url() ?>/espaceClient" method="post">
                <label class="labelRecupMail">Votre pseudo :</label>
                <div class="divInputEtLien">
                    <input type="text" name="email" required="required" value="<?= $pseudo?>" disabled/>
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                    </a>
                </div>
                <label class="labelRecupMail">Votre prénom :</label>
                <div class="divInputEtLien">
                    <input type="text" name="email" required="required" value="<?= $surname?>" disabled/>
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                    </a>
                </div>
                <label class="labelRecupMail">Votre nom :</label>
                <div class="divInputEtLien">
                    <input type="text" name="email" required="required" value="<?= $firstname?>" disabled/>
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                    </a>
                </div>
                <label class="labelRecupMail">Votre adresse mail :</label>
                <div class="divInputEtLien">
                    <input type="email" name="email" required="required" value="<?= $email?>" disabled/>
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                    </a>
                </div>
                <label class="labelRecupMail">Votre mot de passe :</label>
                <div class="divInputEtLien">
                    <?php $motDePasse = "motDePassemotDePasse"; ?>
                    <input type="password" name="motDePasse" required="required" value="<?= $motDePasse?>" disabled/>
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                    </a>
                </div>
                <div class="divAdressesCli">
                    <div>
                        <h3>Vos adresses de facturation :</h3>
                        <ul>
                            <?php
                                foreach($adresseFact as $adresse)
                                {
                                    foreach ($adresse->get() as $champs)
                                    {
                                        echo '<li>'.$champs.'</li>';
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                    <div>
                        <h3>Vos adresses de livraison :</h3>
                        <ul>
                            <?php
                                foreach($adresseLivr as $adresse)
                                {
                                    foreach ($adresse->get() as $champs)
                                    {
                                        echo '<li>'.$champs.'</li>';
                                    }
                                }
                            ?>
                        </ul>    
                    </div>    
                </div>
                <input type="submit" value="Enregistrer"/>
            </form>    
        </section>
    </div>
</main>
<?php require("footer.php"); ?>