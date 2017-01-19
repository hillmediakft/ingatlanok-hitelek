<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{title}</title>

</head>
<body>

    <h3>Kedves {user_name}!</h3>
    <p>A {user_email} e-mail címmel regisztráltál a {from_email} című oldalunkra.</p>
    <p> Regisztrációd megtörtént, de jelenleg passzív.</p>
    <a href="<?php echo BASE_URL; ?>'/felhasznalo/aktival/{user_id}/{user_activation_hash}">Klikkel erre a linkre a regisztraciód aktiválásához!</a>
    <p>Az aktiválást követően a <?php echo BASE_URL; ?> oldalára jutsz, ahol bejelentkezhetsz a felhasználó neveddel és jelszavaddal.</p>
    <p>Üdvözlettel:<br>**********</p>

</body>
</html>