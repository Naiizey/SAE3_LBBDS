<?php require __DIR__ . "/../header.php";?>
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
                                        <a class="lienSupprimer"></a>
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
                        <label>Durée (secondes)<span class="requis">*</span> : </label>
                        <input name="duree" type="number" pattern="/^\d*[1-9]\d*$/" min="1" required>
                    </div>
                        <div class="raison">
                            <label>Raison<span class="requis">*</span> : </label>
                            <textarea rows="3" name="raison" maxlength="50" required></textarea>
                        </div>
                </div>
                <div class="alerte-footer"><hr>
                    <div class="espace-interraction">
                        <button name="timeoutClient" id="Bannir" class="normal-button petit-button rouge">Bannir</button>
                        <button id="fermerTimeout" class="normal-button petit-button blanc">Fermer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php require __DIR__ . "/../footer.php";?>
<script>
    <?php if(isset($bannir)): ?>
        var bannir = <?php $bannir ?>;
    <?php else: ?>
        var bannir = false;
    <?php endif; ?>
    lstClients();
</script>