<!DOCTYPE html>
<html lang="en">

<?php require("head.php"); ?>

<body>

<?php require("menu.php"); ?>

<main>

    <p>
        Denimo, da imamo naslednji problem:
        <br>
    </p>
    <div class="definition">
    <p>
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
    </div>

    <p>
        Čez seznam bi lahko zgradili binarno drevo (segmentno drevo), kjer so listi števila iz seznama in vsak starš ima vrednost vsote svojih otrok.
        <br>
    </p>
        <img src="static/segmentno_drevo.png" alt="binarno drevo">
    <p>
        <br>
        Za intervalne poizvedbe bi lahko uporabili segmente in bi tako zmanjšali časovno zahtevnost iz O(n) na O(log(n)) - primer narisan z rdečo barvo.
        <br>
        <br>
        Za spreminjanje vrednosti na i-tem mestu pa bi morali posodobiti vse segmente, ki vsebujejo to vrednost, kar bi bilo O(log(n)) posodobitev - primer z vijolično barvo.
    </p>

    <h1>Implementacija</h1>

    <p>
        Dajmo oštevilčiti vozlišča drevesa od leve proti desni in od zgoraj navzdol.
    </p>

    <img src="static/segmentno_drevo_2.png" alt="binarno drevo">

    <p>
        Opazimo naslednjo lepo lastnost:
    </p>
    <div class="definition">
        Za vozliše s številko <b>i</b> imata njegova otroka številki <b>2i</b> in <b>2i + 1</b> in starš številko <b>i / 2</b> (zaokroženo navzdol).
    </div>
    <p>
        Kar pomeni, da lahko vsa vozlišča drevesa shranimo v tabelo velikosti <b>2n</b> in prvi element na položaju <b>0</b> je zanemarjen.
        To tudi pomeni, da je list na položaju <b>n + i</b>, kjer je <b>i</b> položaj v tabeli.
    </p>
    <pre class="prettyprint">
typedef long long ll;

struct SegTree {
    int tree_size;
    ll* tree;
    SegTree(int size) {
        tree_size = 1;
        while(tree_size < size)
            tree_size *= 2;
        tree = new ll(2 * tree_size);
    }

    ll get(int node, int rl, int rr, int l, int r);

    ll get(int l, int r) {
        return get(1, 0, tree_size, l, r);
    }

    void set(int i, int val);
};</pre>

    <p>
        Tukaj <b>tree_size</b> predstavlja velikost tabele. Število vozliš je potem <b>2 * tree_size - 1</b>.
        <b>tree_size</b> mora biti potenca dvojke, da lahko drevo zgradimo.
    </p>
    <p>
        Funkcija <b>get</b> vrne vsoto na preseku intervalov <b>[l, r)</b> in <b>[rl, rr)</b>.
        <b>node</b> predstavlja trenutno vozlišče, <b>rl</b> in <b>rr</b> pa interval, ki ga to vozlišče pokriva.
        Sicer bi se dalo iz same številke vozlišča izračunati interval, je tako bolj pregledno in hitreje.
        <b>l</b> in <b>r</b> predstavljata interval, ki ga iščemo.
    </p>
    <p>
        Funkcija <b>set</b> nastavi vrednost na položaju <b>i</b> na <b>val</b>. V tem primeru je to vozlišče <b>tree_size + i</b>.
    </p>

    <h1 id="razmislek">Rekurzivni Razmislek</h1>

</main>

</body>

</html>