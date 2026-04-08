<?php

$komunikat = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $imie = trim($_POST["imie"]);
    $nazwisko = trim($_POST["nazwisko"]);
    $email = trim($_POST["mail"]);
    $temat = trim($_POST["temat"]);
    $tresc = trim($_POST["tresc"]);

    if (empty($imie) || empty($nazwisko) || empty($email) || empty($temat) || empty($tresc)) {
        $komunikat = "Wszystkie pola są wymagane!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $komunikat = "Niepoprawny email!";
    } else {

        $linia = $imie . "|" . $nazwisko . "|" . $email . "|" . $temat . "|" . $tresc . "\n";

        file_put_contents("dane.txt", $linia, FILE_APPEND);

        $komunikat = "Wiadomość została zapisana!";
    }
}
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wiadomości</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>Wyślij wiadomość</h1>
    </header>

    <main>
        <section class="formularz">
        <form method="POST">
            <label for="imie">Imię:</label>
            <input type="text" name="imie" id="imie" required>

            <br> <br>

            <label for="nazwisko">Nazwisko:</label>
            <input type="text" name="nazwisko" id="nazwisko" required>

            <br> <br>

            <label for="mail">Email:</label>
            <input type="email" name="mail" id="mail" required>

            <br> <br>

            <label for="temat">Temat:</label>
            <input type="text" name="temat" id="temat" required>

            <br> <br>

            <label for="tresc">Treść wiadomości:</label>
            <textarea name="tresc" id="tresc" rows="5" placeholder="Treść wiadomości..." required></textarea>

            <br> <br>

            <button type="submit">Wyślij</button>
        </form>

        <p style="color: green;"> <?php echo $komunikat; ?> </p>

        <h2>Zapisane wiadomości</h2>

        <table border="1" cellpadding="10">
            <tr>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Email</th>
                <th>Temat</th>
                <th>Treść</th>
            </tr>

    <?php
        if (file_exists("dane.txt")) {

            $linie = file("dane.txt");

            foreach ($linie as $linia) {
                $dane = explode("|", trim($linia));

                if (count($dane) == 5) {
                    echo "<tr>";
                    foreach ($dane as $pole) {
                        echo "<td>" . htmlspecialchars($pole) . "</td>";
                    }
                    echo "</tr>";
                }
            }
        }
    ?>
        </table>
    </section>
    </main>

    <footer>
        <p>&copy; 2026 Wiadomości. Wszelkie prawa zastrzeżone.</p>
    </footer>

</body>
</html>