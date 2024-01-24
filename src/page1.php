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
        Imamo seznam števil velikosti <b>n</b>.
        Podpirati moramo naslednji dve operaciji:
    </p>

    <ul>
    <li>
        Vrni vsoto vseh števil iz seznama s položaji na intervalu <b>[i, j)</b>.
    </li>
    <li>
        Nastavi število na <b>i</b>-tem polozžaju na <b>x</b>.
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
        Za intervalne poizvedbe bi lahko uporabili segmente in bi tako zmanjšali časovno zahtevnost iz <b>O(n)</b> na O(log(n)) - primer narisan z rdečo barvo.
        <br>
        <br>
        Za spreminjanje vrednosti na <b>i</b>-tem mestu pa bi morali posodobiti vse segmente, ki vsebujejo to vrednost, kar bi bilo <b>O(log(n))</b> posodobitev - primer z vijolično barvo.
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

    <pre class="prettyprint">
void SegTree::set(int i, int val) {
    int node = tree_size + i;
    tree[node] = val;
    node /= 2;

    while(node > 0) {
        tree[node] = tree[2 * node] + tree[2 * node + 1];
        node /= 2;
    }
}</pre>

    <p>
        Tukaj najprej <b>node</b> nastavimo na list, ki predstavlja spremenjeno vrednost in ga nastavimo na <b>val</b>.
        <b>node /= 2</b> ga premakne na starša in se tako pomikamo gor po drevesu.
        Nato v zanki posodabljamo vrednosti vseh staršev, dokler ne pridemo do korena.
        <b>tree[node] = tree[2 * node] + tree[2 * node + 1];</b> zgolj poskrbi, da je vrednost vozlišča enaka vsoti vrednosti njegovih otrok.
    </p>
    <p>
        Brez posebnih razmislekov lahko hitro vidimo, da je časovna zahtevnost te funkcije <b>O(log(n))</b>.
    </p>

    <h1 id="razmislek">Rekurzivni Razmislek</h1>
    <pre class="prettyprint">
ll SegTree::get(int node, int rl, int rr, int l, int r) {
    if(r <= rl || rr <= l)
        return 0;

    if(l <= rl && rr <= r)
        return tree[node];

    int mid = (rl + rr) / 2;
    return get(2 * node, rl, mid, l, r) + get(2 * node + 1, mid, rr, l, r);
}</pre>
    <p>
        Prvi if stavek preveri, če je interval, ki ga iščemo, popolnoma zunaj intervala, ki ga pokriva trenutno vozlišče.
        V tem primeru vrnemo 0, saj ta interval ne vsebuje ničesar od tistega, kar iščemo.
    </p>
    <p>
        Drugi if stavek preveri, če je interval, ki ga iščemo, popolnoma v intervalu, ki ga pokriva trenutno vozlišče.
        V tem primeru vrnemo vrednost tega vozlišča, saj vsebuje vse, kar iščemo.
    </p>
    <p>
        Če ni noben od teh dveh primerov, potem interval, ki ga iščemo, delno vsebuje interval, ki ga pokriva trenutno vozlišče,
        zato rekurzivno pokličemo funkcijo na obeh otrocih in vrnemo njuno vsoto.
        Opazimo, da se interval, ki ga iščemo, vedno zmanjša, zato se bo rekurzija slej ko prej končala.
    </p>
    <p>
        Po ne tako trivialnem razmisleku lahko vidimo, da je časovna zahtevnost te funkcije <b>O(log(n))</b>.
        Zakaj to drži?
        V to se ne bomo spuščali in je zato prepuščeno bralcu le kot razmislek.
        Bodisi je to formalen dokaz ali pa zgolj intuitivno razumevanje.
    </p>

</main>

</body>

</html>