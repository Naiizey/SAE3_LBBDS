<?php require("header.php");?>
    <main>
        <div class="divLst">
            <?php if(!empty($clients)): ?>
                <table class="tableLst">
                    <thead>
                        <tr>
                            <th>N° client</th>
                            <th>Identifiant</th>
                            <th>Sanctionner</th>                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clients as $client): ?>
                            <tr class='lignesClients'>
                                <td class='numClients'><?= $client->numero ?></td>
                                <td><?= $client->identifiant ?></td>
                                <td>
                                    <button class="buttonSanction"></button>
                                </td>
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
            <p class="message-alerte">Quel type de sanction ?</p>
            <div class="alerte-footer">
                <hr>
                <div class="espace-interraction">
                    <div>
                        <button id="timeout" class="normal-button petit-button rouge">Bannir temporairement</button>
                        <button id="ban" class="normal-button petit-button rouge">Bannir définitivement</button>
                        <button id="fermer" class="normal-button petit-button blanc">Fermer</button>
                    </div>
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
                            <textarea rows="3" name="raison" required></textarea>
                        </div>
                </div>
                <div class="alerte-footer"><hr>
                    <div class="espace-interraction">
                        <div>
                            <button name="timeoutClient" id="Bannir" class="normal-button petit-button rouge">Bannir</button>
                            <button id="fermerTimeout" class="normal-button petit-button blanc">Fermer</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php require("footer.php");?>
<script>
    lstClients();
</script>