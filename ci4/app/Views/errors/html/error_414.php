<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Error 414 - URI Too Long</title>
    <link rel="stylesheet" href="<?=base_url()?>/css/style.css"/>
</head>
    <body>
        <div class="flex-center full-height">
            <div>
                <div id="error_text">
                    <span class="source">Error 414: <span data-l10n>URI Too Long</span></span>
                    <span class="target"></span>
                </div>
                <div class="hidden" id="details">
                    <table>
                        <tr>
                            <td class="name"><span data-l10n>Hôte</span>:</td>
                            <td class="value">Alizon.net</td>
                        </tr>
                        <tr>
                            <td class="name"><span data-l10n>URL</span>:</td>
                            <td class="value"><a href="https://www.alizon.net">Alizon.net</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
<script src="<?= base_url()?>/js/script.js"></script>
<script>errors();</script>