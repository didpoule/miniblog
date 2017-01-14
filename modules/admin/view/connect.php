<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Connexion à l'espace d'Administration</title>
    <link href="modules/admin/view/style.css" rel="stylesheet"/>
</head>

<body>
<?php
if($errmsg)
{
    echo getErrMsg($errmsg);
}
?>
    <h1>Connexion à l'espace d'Administration</h1>
    <p>Entrez votre login et votre mot de passe pour vous connecter.</p>
    <form method='post'>
        <p>
            Login : <input type='text' name='login'><br/>
            Mot de passe : <input type='password' name='password'><br/><br/>

            <input type='submit' name='connexion' value='connexion'>
        </p>
</body>
</html>