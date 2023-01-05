<?php namespace App\Controllers;

use CodeIgniter\CodeIgniter;
use Config\Services;
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
        $config['protocol'] = 'smtp';
        $config['SMTPHost'] = 'smtp-relay.sendinblue.com';
        $config['SMTPUser'] = 'lucienherve3009@gmail.com';
        $config['SMTPPass']  = 'TZDvz75mkVL6A4tJ';
        $config['SMTPPort'] = '587';
        $this->email = \Config\Services::email();
        $this->email->initialize($config);
        if (!isset($_SESSION['code'])) {
            $_SESSION['code'] = $this->genererCode();
        }   
        $this->email->setFrom('admin@alizon.net', 'Admin Alizon');
    }

    public function mdpOublie($post = null, $data = null)
    {
        $data["controller"]= "mdpOublie";

        //Pré-remplit les champs s'ils ont déjà été renseignés juste avant de potentielles erreurs
        $data['email'] = (isset($post['email'])) ? $post['email'] : "";
        $data['code'] = (isset($post['code'])) ? $post['code'] : "";
        return view('page_accueil/mdpOublie.php', $data);
    }

    public function genererCode() {
        $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($caracteres);
        $code = '';
        for ($i = 0; $i < 5; $i++) {
            $code .= $caracteres[rand(0, $charactersLength - 1)];
        }
        strval($code);
        return $code;
    }

    public function obtenirCode() 
    {
        $post=$this->request->getPost();
        $_SESSION["userMail"] = $post['email'];
        $clientModel = model("\App\Models\Client");
        if ($clientModel->doesEmailExists($_SESSION["userMail"]))
        {
            $_SESSION['code'] = $this->genererCode();
            $message = "Bonjour,\nVoici le code généré suite à votre demande de changement de mot de passe :" . $_SESSION['code'] . "\nSi vous n'êtes pas à l'origine de cette demande, veuillez le signaler a cet email : admin@alizon.net";
            $this->email->setFrom('admin@alizon.net', 'Admin - [ALIZON]');
            $this->email->setTo($_SESSION["userMail"]);
            $this->email->setSubject('Récupération de mot de passe');
            $this->email->setMessage($message);
            $this->email->send();
            $data['retour'][0] = "Renseignez le code qui vous a été envoyé par mail.";
        } 
        else 
        {
            $data['retour'][1] = "L'adresse mail ne correspond à aucun compte.";
        }
        return $this->mdpOublie($post, $data);
    }

    public function motDePasseAlea() {
        return $this->genererCode() . $this->genererCode();
    }

    public function validerCode()
    {
        $post=$this->request->getPost();
        echo($_SESSION['code']);
        if ($post['code'] == $_SESSION['code']) 
        {
            $model = model("App\Models\Client");
            $nouveauMDP = $this->motDePasseAlea();
            $entree = $model->where('email',$_SESSION["userMail"])->findAll()[0];
            $entree->motDePasse=$nouveauMDP;
            $entree->cryptMotDePasse();
            $model->save($entree);
            $message = "Bonjour,\nVoici votre nouveau mot de passe :" . $nouveauMDP . "\nSi vous n'êtes pas à l'origine de cette demande, veuillez le signaler a cet email : admin@alizon.net";
            $this->email->setFrom('admin@alizon.net', 'Admin - [ALIZON]');
            $this->email->setTo($_SESSION["userMail"]);
            $this->email->setSubject('Nouveau mot de passe');
            $this->email->setMessage($message);
            $this->email->send();
            $data['retour'][0] = "Renseignez le code qui vous a été envoyé par mail.";
            $data['retour'][3] = "Un nouveau mot de passe vous a été envoyé par mail.";
        } 
        else 
        {
            $data['retour'][4] = "Erreur, code invalide.";
        }
        return $this->mdpOublie($post, $data);
    }
}