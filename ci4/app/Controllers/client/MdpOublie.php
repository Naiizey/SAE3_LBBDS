<?php

namespace App\Controllers\client;

use CodeIgniter\CodeIgniter;
use Config\Services;
use App\Controllers\BaseController;
use Exception;

class MdpOublie extends BaseController
{
    private $email;

    public function __construct()
    {
        helper('cookie');
        if (session()->has("numero")) {
            $GLOBALS["quant"] = model("\App\Model\ProduitPanierCompteModel")->compteurDansPanier(session()->get("numero"));
        } else if (has_cookie("token_panier")) {
            $GLOBALS["quant"] = model("\App\Model\ProduitPanierVisiteurModel")->compteurDansPanier(get_cookie("token_panier"));
        } else {
            $GLOBALS["quant"] = 0;
        }
        $this->email = \Config\Services::email();
        // $this->email->initialize();
        if (!isset($_SESSION['code'])) {
            $_SESSION['code'] = $this->genererCode();
        }
    }

    public function mdpOublie($post = null, $data = null)
    {
        $data["controller"] = "mdpOublie";

        //Pré-remplit les champs s'ils ont déjà été renseignés juste avant de potentielles erreurs
        $data['email'] = (isset($post['email'])) ? $post['email'] : "";
        $data['code'] = (isset($post['code'])) ? $post['code'] : "";
        return view('client/mdpOublie.php', $data);
    }

    public function genererCode()
    {
        $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($caracteres);
        $code = '';
        for ($i = 0; $i < 5; $i++) {
            $code .= $caracteres[rand(0, $charactersLength - 1)];
        }
        return $code;
    }

    public function obtenirCode()
    {
        $post = $this->request->getPost();
        $_SESSION["userMail"] = $post['email'];
        $clientModel = model("\App\Models\Client");
        if ($clientModel->doesEmailExists($_SESSION["userMail"])) {
            $_SESSION['code'] = $this->genererCode();
            $contenu = 'Voici le code de récupération pour votre compte :<br><span style="display: block;text-align: center;font-size:x-large">' . $_SESSION['code'] . '</span><br>Si vous n\'êtes pas l\'auteur de cette demande, ignorez ce mail ou contactez le support : support@alizon.net';
            $message = $this->genererMail("Réinitialiser votre mot de passe", $contenu);
            $this->email->setTo($_SESSION["userMail"]);
            $this->email->setSubject('Récupération de mot de passe  ');
            $this->email->setMessage($message);
            $this->email->send();
        }
        $data['retour'][0] = "Si votre adresse est bien liée à un compte, renseignez le code qui vous a été envoyé par mail.";
        return $this->mdpOublie($post, $data);
    }

    public function motDePasseAlea()
    {
        return $this->genererCode() . $this->genererCode();
    }

    public function validerCode()
    {
        $post = $this->request->getPost();
        echo ($_SESSION['code']);
        if ($post['code'] == $_SESSION['code']) {
            $model = model("App\Models\Client");
            $nouveauMDP = $this->motDePasseAlea();
            $entree = $model->where('email', $_SESSION["userMail"])->findAll()[0];
            $entree->motDePasse = $nouveauMDP;
            $entree->cryptMotDePasse();
            $model->save($entree);
            $contenu = 'Voici le nouveau mot de passe de votre compte :<br><span style="display: block;text-align: center;font-size:x-large">' . $nouveauMDP . '</span>Ceci est un mot de passe temporaire, vous pouvez le changer dans les paramètres de votre compte.<br>Si vous n\'êtes pas l\'auteur de cette demande, ignorez ce mail ou contactez le support : support@alizon.net';
            $message = $this->genererMail("Nouveau mot de passe", $contenu);
            $this->email->setFrom('admin@alizon.net', 'Administrateur - Alizon.net');
            $this->email->setTo($_SESSION["userMail"]);
            $this->email->setSubject('Nouveau mot de passe');
            $this->email->setMessage($message);
            $this->email->send();
            $data['retour'][0] = "Renseignez le code qui vous a été envoyé par mail.";
            $data['retour'][3] = "Un nouveau mot de passe vous a été envoyé par mail.";
        } else {
            $data['retour'][4] = "Erreur, code invalide.";
        }
        return $this->mdpOublie($post, $data);
    }

    
    private function genererMail($titre, $contenu)
    {
        return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="font-family:arial, \'helvetica neue\', helvetica, sans-serif"><head><meta charset="UTF-8"><meta content="width=device-width, initial-scale=1" name="viewport"><meta name="x-apple-disable-message-reformatting"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta content="telephone=no" name="format-detection"><title>New message 2</title><!--[if (mso 16)]><style type="text/css">     a {text-decoration: none;}     </style><![endif]--><!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--><!--[if gte mso 9]><xml> <o:OfficeDocumentSettings> <o:AllowPNG></o:AllowPNG> <o:PixelsPerInch>96</o:PixelsPerInch> </o:OfficeDocumentSettings> </xml><![endif]--><!--[if !mso]><!-- --><link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i" rel="stylesheet"><!--<![endif]--><style type="text/css">#outlook a {	padding:0;}.es-button {	mso-style-priority:100!important;	text-decoration:none!important;}a[x-apple-data-detectors] {	color:inherit!important;	text-decoration:none!important;	font-size:inherit!important;	font-family:inherit!important;	font-weight:inherit!important;	line-height:inherit!important;}.es-desk-hidden {	display:none;	float:left;	overflow:hidden;	width:0;	max-height:0;	line-height:0;	mso-hide:all;}[data-ogsb] .es-button {	border-width:0!important;	padding:15px 20px 15px 20px!important;}@media only screen and (max-width:600px) {p, ul li, ol li, a { line-height:150%!important } h1, h2, h3, h1 a, h2 a, h3 a { line-height:120% } h1 { font-size:36px!important; text-align:left } h2 { font-size:28px!important; text-align:center!important } h3 { font-size:20px!important; text-align:center!important } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:36px!important; text-align:left } .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:28px!important; text-align:center!important } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:20px!important; text-align:center!important } .es-menu td a { font-size:14px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:14px!important } .es-content-body p, .es-content-body ul li, .es-content-body ol li, .es-content-body a { font-size:14px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:14px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button, button.es-button { font-size:18px!important; display:block!important; border-right-width:0px!important; border-left-width:0px!important } .es-adaptive table, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0!important } .es-m-p0r { padding-right:0!important } .es-m-p0l { padding-left:0!important } .es-m-p0t { padding-top:0!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important } table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; max-height:inherit!important } .es-m-p5 { padding:5px!important } .es-m-p5t { padding-top:5px!important } .es-m-p5b { padding-bottom:5px!important } .es-m-p5r { padding-right:5px!important } .es-m-p5l { padding-left:5px!important } .es-m-p10 { padding:10px!important } .es-m-p10t { padding-top:10px!important } .es-m-p10b { padding-bottom:10px!important } .es-m-p10r { padding-right:10px!important } .es-m-p10l { padding-left:10px!important } .es-m-p15 { padding:15px!important } .es-m-p15t { padding-top:15px!important } .es-m-p15b { padding-bottom:15px!important } .es-m-p15r { padding-right:15px!important } .es-m-p15l { padding-left:15px!important } .es-m-p20 { padding:20px!important } .es-m-p20t { padding-top:20px!important } .es-m-p20r { padding-right:20px!important } .es-m-p20l { padding-left:20px!important } .es-m-p25 { padding:25px!important } .es-m-p25t { padding-top:25px!important } .es-m-p25b { padding-bottom:25px!important } .es-m-p25r { padding-right:25px!important } .es-m-p25l { padding-left:25px!important } .es-m-p30 { padding:30px!important } .es-m-p30t { padding-top:30px!important } .es-m-p30b { padding-bottom:30px!important } .es-m-p30r { padding-right:30px!important } .es-m-p30l { padding-left:30px!important } .es-m-p35 { padding:35px!important } .es-m-p35t { padding-top:35px!important } .es-m-p35b { padding-bottom:35px!important } .es-m-p35r { padding-right:35px!important } .es-m-p35l { padding-left:35px!important } .es-m-p40 { padding:40px!important } .es-m-p40t { padding-top:40px!important } .es-m-p40b { padding-bottom:40px!important } .es-m-p40r { padding-right:40px!important } .es-m-p40l { padding-left:40px!important } }</style></head>
<body style="width:100%;font-family:arial, \'helvetica neue\', helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0"><div class="es-wrapper-color" style="background-color:#F0F2F4"><!--[if gte mso 9]><v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t"> <v:fill type="tile" color="#f0f2f4"></v:fill> </v:background><![endif]--><table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;background-color:#F0F2F4"><tr><td valign="top" style="padding:0;Margin:0"><table cellpadding="0" cellspacing="0" class="es-header" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top"><tr><td align="center" style="padding:0;Margin:0"><table bgcolor="#ffffff" class="es-header-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px"><tr><td align="left" bgcolor="#f3f3f3" style="padding:0;Margin:0;padding-bottom:20px;background-color:#f3f3f3"><table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="left" style="padding:0;Margin:0;width:600px"><table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" style="padding:0;Margin:0;font-size:0px"><a target="_blank" href="https://viewstripo.email" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#2CB543;font-size:12px"><img src="https://data.lucienherve.xyz/logo_noir.png" alt="Logo" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" height="90" title="Logo"></a></td>
</tr></table></td></tr></table></td></tr></table></td>
</tr></table><table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"><tr><td align="center" style="padding:0;Margin:0"><table bgcolor="#164F57" class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#164f57;width:600px"><tr><td align="left" style="Margin:0;padding-left:30px;padding-right:30px;padding-top:40px;padding-bottom:40px"><table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" valign="top" style="padding:0;Margin:0;width:540px"><table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="left" class="es-m-txt-l" style="padding:0;Margin:0"><h1 style="Margin:0;line-height:65px;mso-line-height-rule:exactly;font-family:\'trebuchet ms\', \'lucida grande\', \'lucida sans unicode\', \'lucida sans\', tahoma, sans-serif;font-size:54px;font-style:normal;font-weight:normal;color:#d9d9d9"><span style="font-size:37px">'. $titre .' </span><span style="font-size:34px"><span style="font-size:12px"><span style="font-size:26px"></span></span></span></h1>
</td></tr></table></td></tr></table></td></tr></table></td>
</tr></table><table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"><tr><td align="center" style="padding:0;Margin:0"><table bgcolor="#fef7f2" class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#fef7f2;width:600px"><tr><td align="left" style="Margin:0;padding-bottom:20px;padding-left:30px;padding-right:30px;padding-top:40px"><table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" valign="top" style="padding:0;Margin:0;width:540px"><table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="left" class="es-m-txt-l" style="padding:0;Margin:0"><h2 style="Margin:0;line-height:43px;mso-line-height-rule:exactly;font-family:\'playfair display\', georgia, \'times new roman\', serif;font-size:36px;font-style:normal;font-weight:normal;color:#123850">Bonjour,</h2>
<p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato, \'helvetica neue\', helvetica, arial, sans-serif;line-height:27px;color:#2E4B62;font-size:18px"><br>' . $contenu .'
</p><td></tr></table></td></tr></table></td>
</tr><tr><td align="left" style="Margin:0;padding-top:20px;padding-left:30px;padding-right:30px;padding-bottom:40px"><table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" valign="top" style="padding:0;Margin:0;width:540px"><table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="right" style="padding:0;Margin:0"><!--[if mso]><a href="mailto:support@alizon.net" target="_blank" hidden> <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" esdevVmlButton href="mailto:support@alizon.net" style="height:54px; v-text-anchor:middle; width:179px" arcsize="0%" stroke="f" fillcolor="#123850"> <w:anchorlock></w:anchorlock> <center style=\'color:#ffffff; font-family:lato, "helvetica neue", helvetica, arial, sans-serif; font-size:20px; font-weight:700; line-height:20px; mso-text-raise:1px\'>Contactez nous</center> </v:roundrect></a><![endif]--><!--[if !mso]><!-- --><span class="msohide es-button-border" style="border-style:solid;border-color:#2CB543;background:#123850;border-width:0px;display:inline-block;border-radius:0px;width:auto;mso-hide:all"><a href="mailto:support@alizon.net" class="es-button" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#FFFFFF;font-size:20px;border-style:solid;border-color:#123850;border-width:15px 20px 15px 20px;display:inline-block;background:#123850;border-radius:0px;font-family:lato, \'helvetica neue\', helvetica, arial, sans-serif;font-weight:bold;font-style:normal;line-height:24px;width:auto;text-align:center">Contactez nous</a></span><!--<![endif]--></td>
</tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div></body></html>
';
    }
}
