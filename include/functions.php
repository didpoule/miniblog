<?php

//Limitation du nombre de caractères à afficher pour une chaîne
function tronquerChaine($str, $longueur)
{
    $str = substr($str, 0, $longueur);
    $lastchar = strrpos($str, ' ');
    $str = substr($str, 0,  $lastchar);
    $str .= '...';
    return $str;
}
// Retourne nombre de pages
function calc_nbPages($nbElement, $nbElementPage)
{
    $nbPages = $nbElement / $nbElementPage;
    $nbPages = ceil($nbPages);
    return $nbPages;
}

// Définit les paramètres OFFSET et LIMIT pour pagination
function donnees_page($page, $nbPages, $nbElementPage)
{
    $page = htmlspecialchars($page);
    $offset = 0;
    $i = 1;
    if ($page <= 0)
    {
        $page = 1;
    }
    elseif ($page > $nbPages)
    {
        $page = $nbPages;
    }
    while ($i < $page)
    {
        $offset += $nbElementPage;
        $i++;
    }
    return $offset;
}
function setUrl()
{
    $baseUrl = NULL;
    if(isset($_GET['section']))
    {
        $baseUrl .=  '?section='.$_GET['section'];
        if(isset($_GET['menu']))
        {
            $baseUrl .= '&menu='.$_GET['menu'];
        }
        if(isset($_GET['action']))
        {
            $baseUrl .= '&action='.$_GET['action'];
        }
        if(isset($_GET['billet'])) {
            $baseUrl .= '&billet=' . $_GET['billet'];
        }
    }
    return $baseUrl;
}
// Selecteur de pages
function pageSelector($nbPages, $baseUrl = NULL)
{
    echo '<nav class="page_select">
           <p><span>Pages: </span>';
        for ($i = 1; $i <= $nbPages; $i++)
        {
            if(!$baseUrl)
            {
                echo '<ul><a href ="?page=' . $i . '">' . $i . '</a>/</ul>';
            }
            else
            {
                echo '<ul><a href="' . $baseUrl . '&page=' . $i . '">' . $i . '</a>/</ul>';
            }
        }
    echo '</p></nav>';
}

// Récupération de l'id de l'auteur
function getIduser($email)
{
    global $bdd;
    $req = $bdd->prepare('SELECT id FROM utilisateurs WHERE email = :email');
    $req->bindParam(':email', $email, PDO::PARAM_STR);
    $req->execute();
    $donnees = $req->fetch();
    $req->closeCursor();
    return $donnees['id'];
}

// Récupération de l'email de l'utilisateur grâce à son id
function getEmailuser($id)
{
    global $bdd;
    $req = $bdd->prepare('SELECT email FROM utilisateurs WHERE id = :id');
    $req->bindParam(':id', $id, PDO::PARAM_INT);
    $donnees = $req->fetch();
    $req->closeCursor();
    return $donnees['email'];
}

// Création d'un utilisateur si adresse mail valide pour utilisation gravatar
function createUser($email, $nom = NULL)
{
    global $bdd;
    $req = $bdd->prepare('INSERT INTO utilisateurs(nom, email)
                                     VALUES(:nom, :email)');
    $req->bindParam(':nom', $nom, PDO::PARAM_STR);
    $req->bindParam(':email', $email, PDO::PARAM_STR);
    $req->execute();
    $req->closeCursor();
}

// Vérification de la validité de l'adresse mail
function verifEmail($email)
{
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $email = NULL;
    }
    return $email;
}

// Récupération du gravatar grâce à l'email, renvoie un avatar par défaut si non existant source www.gravatar.com
function get_gravatar($email, $s = 50, $d = 'mm', $r = 'g', $img = true, $atts = array())
{
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    if ($img)
    {
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val)
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

// Fonctions de cryptage pour mots de passes. Sources www.stackoverflow.com
function encrypt($pure_string, $encryption_key)
{
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
    return $encrypted_string;
}

function decrypt($encrypted_string, $encryption_key)
{
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
    return $decrypted_string;
}

function keyGenerator($param1, $param2)
{
    $key = NULL;
    $key = encrypt($param1, $param2);
    return $key;
}
// Vérification du mot de passe pour la connexion
function controleLogin($user, $login, $password)
{
    $resultat = false;
    if (empty($login) || empty($password))
    {
        return false;
    }
    else
    {
        $key = keyGenerator($login, '0123456789');
        $password = encrypt($password, $key);
    }

    if ($login == $user['login'] && $password == $user['password'])
    {
        $resultat = true;
    }
    return $resultat;
}

// Conversion de la date au format FR
function dateFr($date)
{
    $dateFr = new DateTime($date);
    $dateFr = $dateFr->format('d/m/Y à H:i:s');
    return $dateFr;
}
// Géneration de token
function generer_token($nom = '')
{
    $token = uniqid(rand(), true);
    $_SESSION[$nom.'_token'] = $token;
    $_SESSION[$nom.'_token_time'] = time();
    return $token;
}
// Contrôle de token
function verifier_token($temps, $referer, $nom = '')
{
    $result = false;
    if(isset($_SESSION[$nom.'_token']) && isset($_SESSION[$nom.'_token_time']) && isset($_POST['token']))
    {
        if($_SESSION[$nom.'_token'] == $_POST['token'])
        {
            if($_SESSION[$nom.'_token_time'] >= (time() - $temps))
            {
                if($_SERVER['HTTP_REFERER'] == $referer)
                {
                    $result = true;
                }
            }
        }
    }
    return $result;
}
function getParam($param)
{
    global $bdd;
    $req = $bdd->prepare('SELECT valeur FROM parametres WHERE nom = :param');
    $req->bindParam(':param', $param);
    $req->execute();
    $donnees = $req->fetch();
    $req->closeCursor();
    return $donnees['valeur'];
}
// Messages d'erreur
function getErrMsg($errMsg = 0)
{
    switch ($errMsg):
        case 1:
            return 'Ce billet n\'existe pas.';
            break;

        case 2:
            return 'Cette page n\'existe pas.';
            break;

        case 3:
            return 'Le commentaire n\'a pas été envoyé car il était vide.';
            break;

        case 4:
            return 'Erreur: Les informations saisies ne sont pas correctes.';
            break;

        case 5:
            return 'Le billet n\'a pas été créé car il ne contient pas de titre ou de contenu.';
            break;

        case 6:
            return 'Aucun compte administrateur trouvé, veuillez remplir le formulaire pour le définir.';
            break;

        case 7:
            return 'Veuillez remplir tous les champs.';
            break;

        case 8:
            return 'Le token a expiré, l\'opération n\'a pas été effectuée.';
            break;

        case 9:
            return 'Aucun billet à afficher.';
            break;

        case 10:
            return 'Aucun commentaire à afficher.';
            break;

        case 11:
            return 'Votre commentaire a bien été envoyé, cependant il doit être validé par un administrateur
                    pour être affiché.';
            break;
        default:
            return NULL;
            break;

    endswitch;
}

function closePopup()
{
    echo '
                <form method="post">
                    <input type="submit" name="ok" value="Fermer" />
                </form>';
}