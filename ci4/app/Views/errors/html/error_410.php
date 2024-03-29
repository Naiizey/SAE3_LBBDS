<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Error 410 - Gone</title>
    <link rel="stylesheet" href="<?=base_url()?>/css/style.css"/>
</head>
    <body>
        <div class="flex-center full-height">
            <div>
                <div id="error_text">
                    <span class="source">Error 410: <span data-l10n>Gone</span></span>
                    <span class="target"></span>
                </div>
                <div class="hidden" id="details">
                    <p>
                        <span class="name"><span data-l10n>Hôte</span>:</span>
                        <span class="value">Alizon.net</span>
                    </p>
                    <p>
                        <span class="name"><span data-l10n>URL</span>:</span>
                        <span class="value"><a href="https://www.alizon.net">Alizon.net</a></span>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
<script src="<?= base_url()?>/js/script.js"></script>
<script>errors();</script>