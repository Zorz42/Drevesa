<!DOCTYPE html>
<html lang="en">

<?php require("head.php"); ?>

<body>

<?php require("menu.php"); ?>

<main>

    Denimo, da imamo nov problem, sicer podoben prejšnjemu:
    <div class="definition">
        <p>
            Imamo seznam števil velikosti n.
            Podpirati moramo naslednji dve operaciji:
        </p>

        <ul>
            <li>
                Vrni vsoto vseh števil iz seznama s položaji na intervalu <b>[i, j)</b>.
            </li>
            <li>
                Povečaj vsa števila s položaji na intervalu <b>[i, j)</b> za <b>x</b>.
            </li>
        </ul>
    </div>

    <p>
        Pri tej nalogi tudi lahko uporabimo segmentno drevo, vendar moramo biti pri posodabljanju pazljivi, saj bi
        lahko v najslabšem primeru posodobili celo drevo, ko spreminjamo vrednosti.
        Rešitev je, da za vsako vozlišče shranimo še vrednost, ki jo moramo prišteti na temu pripadajočem intervalu.
        Tej vrednosti pravimo <b>lazy</b>, saj na len način odlašamo s posodabljanjem.
        Velikokrat je odlašanje v algorithmih brez pomena, saj moramo neko stvar narediti slej ko prej, vendar pri tej nalogi
        se pa časovna zahtevnost celo spremeni.
    </p>

    <p>
        Časovna zahtevnost je sedaj <b>O(log(n))</b> za vsako poizvedbo in posodobitev. To drevo je sposobno vsega, kar je sposobno
        tudi navadno segmentno drevo brez nekih omembe vrednih časovnih izgub.
    </p>

    <h1>Implementacija</h1>

</main>

</body>

</html>
