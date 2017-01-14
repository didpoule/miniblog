<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Paramètres de connexion à l'espace d'Administration</title>
    <link href="modules/admin/view/style.css" rel="stylesheet"/>
</head>

<body>
<?php
if($errmsg)
{
    echo getErrMsg($errmsg);
}?>
    <h1>Modification de l'administrateur</h1>
    <form method='post' action="?section=admin&menu=paramAdmin">
        <p>
            <input type="hidden" name="token" value="<?= $token ?>"/>
            Login : <input type='text' name='login'/><br />
            Email : <input type="email" name="email"/><br />
            Mot de passe : <input type='password' name='password'/><br />
            Confirmez votre mot de passe : <input type="password" name="checkPassword" /><br />
            <input type='submit' value='Modifier' name="changeAdmin">
        </p>
    </form>
</body>
</html>