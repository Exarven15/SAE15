<?php 

$pass = "Rionoir2111*";

function securePassword($pass): string
{
    $s = openssl_digest(
        random_bytes(64),
        'sha256'
    );
    
    $h = openssl_digest(
        $pass . $s,
        'sha256'
    );
    $r = $s.$h;
    return $r;
}

?>