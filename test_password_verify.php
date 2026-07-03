<?php
// Test script per verificare password/hash
// Accesso DB come in func3.php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'myhmsdb';

// Username da controllare
$username = 'admin';
// Password da verificare
$plaintext = 'admin123';

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . "\n");
}

$stmt = $mysqli->prepare('SELECT password FROM admintb WHERE username = ? LIMIT 1');
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($hash_from_db);
if (!$stmt->fetch()) {
    echo "Nessun utente trovato per username=\"$username\"\n";
    exit(1);
}
$stmt->close();

echo "Raw DB value: [" . $hash_from_db . "]\n";
echo "Length raw: " . strlen($hash_from_db) . "\n";

$trimmed = trim($hash_from_db);
echo "After trim: [" . $trimmed . "]\n";
echo "Length trimmed: " . strlen($trimmed) . "\n";

// Mostra i primi e ultimi 4 byte in esadecimale per rilevare caratteri invisibili
function hex_excerpt($s, $len=4){
    $pre = substr($s, 0, $len);
    $post = substr($s, -$len);
    return strtoupper(bin2hex($pre)) . ' ... ' . strtoupper(bin2hex($post));
}

echo "Hex excerpt raw: " . hex_excerpt($hash_from_db) . "\n";

// Verifica direttamente
$result_raw = password_verify($plaintext, $hash_from_db) ? 'MATCH' : 'NO MATCH';
$result_trim = password_verify($plaintext, $trimmed) ? 'MATCH' : 'NO MATCH';

echo "password_verify with raw DB value: $result_raw\n";
echo "password_verify with trimmed DB value: $result_trim\n";

// Mostra hash generato per la password plaintext (solo per confronto manuale)
$newhash = password_hash($plaintext, PASSWORD_BCRYPT);
echo "New hash for '$plaintext': $newhash\n";

$mysqli->close();

// Suggerimento breve
echo "\nSe ottieni MATCH con trimmed ma NO MATCH con raw, rimuovi spazi nel DB o applica trim() prima di password_verify.\n";
?>