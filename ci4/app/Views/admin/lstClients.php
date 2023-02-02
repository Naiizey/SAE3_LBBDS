<?php require("header.php"); ?>
    <main>
        <div class="divLst">
            <?php if(!empty($clients)): ?>
                <table class="tableLst">
                    <thead>
                        <tr>
                            <th>N° compte</th>
                            <th>Identifiant</th>
                            <?php if(isset($bannir)) : ?>
                                <?php if ($bannir) : ?>
                                    <th>Bannir</th>
                                <?php endif; ?>
                            <?php else: ?>
                                <th>Supprimer</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clients as $client): ?>
                            <tr class='lignesClients'>
                                <td class='numClients'><?= $client->numero ?></td>
                                <td><?= $client->identifiant ?></td>
                                <?php if(isset($bannir)) : ?>
                                    <?php if ($bannir) : ?>
                                        <td>
                                            <button class="buttonSanction"></button>
                                        </td>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <td>
                                        <a href="<?= base_url() . "/admin/clients/" . $client->numero ?>">
                                            <svg class="svgSupr" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                            </svg> 
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <h2>Il n'y a pas de clients pour le moment.</h2>
            <?php endif; ?>
        </div>
    </main>
    <div class="sur-alerte sur-alerteSanctions">
        <div class="alerte">
            <h2 class="titreSanction"></h2>
            <hr>
            <p class="message-alerte">Quel type de ban ?</p>
            <div class="alerte-footer">
                <hr>
                <div class="espace-interraction">
                    <button id="timeout" class="normal-button petit-button rouge">Bannir temporairement</button>
                    <button id="ban" class="normal-button petit-button rouge">Bannir définitivement</button>
                    <button id="fermer" class="normal-button petit-button blanc">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    <div class="sur-alerte sur-alerteTimeout">
        <div class="alerte">
            <h2 class="titreSanction"></h2>
            <hr>
            <form method="POST">
                <input id="numClient" type="hidden" name="numClient">
                <div class="div-inputs">
                    <div class="duree">
                        <label>Durée (jour)<span class="requis">*</span> : </label>
                        <input name="duree" type="number" min="1" max="2910000" required>
                    </div>
                    <div class="raison">
                        <label>Raison<span class="requis">*</span> : </label>
                        <textarea rows="3" name="raison" maxlength="50" required></textarea>
                    </div>
                </div>
                <div class="alerte-footer"><hr>
                    <div class="espace-interraction">
                        <button type="submit" name="timeoutClient" id="Bannir" class="normal-button petit-button rouge">Bannir</button>
                        <button id="fermerTimeout" class="normal-button petit-button blanc">Fermer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php require("footer.php");?>
<script>
    <?php if(isset($bannir)): ?>
        var bannir = <?= $bannir ?>;
    <?php else: ?>
        var bannir = false;
    <?php endif; ?>
    lstClients();
</script>