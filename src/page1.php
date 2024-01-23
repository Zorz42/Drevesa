<!DOCTYPE html>
<html lang="en">

<?php require("head.php"); ?>

<body>

<?php require("menu.php"); ?>

<main>

    <p>
        Denimo, da imamo naslednji problem:
        <br>
        Imamo seznam števil velikosti n.
        Podpirati moramo naslednji dve operaciji:
    </p>

    <ul>
    <li>
        vrni vsoto vseh števil iz seznama s položaji na intervalu [i, j)
    </li>
    <li>
        nastavi število na i-tem polozžaju na x
    </li>
    </ul>

    <p>
        Čez seznam bi lahko zgradili binarno drevo (segmentno drevo), kjer so listi števila iz seznama in vsak starš ima vrednost vsote svojih otrok.
        <br>
    </p>
        <img src="../static/segmentno_drevo.png" alt="binarno drevo" width="50%">
    <p>
        <br>
        Za intervalne poizvedbe bi lahko uporabili segmente in bi tako zmanjšali časovno zahtevnost iz O(n) na O(log(n)) - primer narisan z rdečo barvo.
        <br>
        Za spreminjanje vrednosti na i-tem mestu pa bi morali posodobiti vse segmente, ki vsebujejo to vrednost, kar bi bilo O(log(n)) posodobitev - primer z vijolično barvo.
    </p>

</main>

</body>

</html>