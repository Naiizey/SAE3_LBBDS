

<head>
<link rel="stylesheet" href="<?= base_url() ?>/css/style.css">
</head>

<?php
$prod->lienimage = 'ressources/images.jpg';

echo $cardProduit->display($prod);
?>