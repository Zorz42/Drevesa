<!DOCTYPE html>
<html lang="en">

<?php require("head.php"); ?>

<body>

<?php require("menu.php"); ?>

<main>

    <p>
        Denimo, da imamo nov problem, sicer podoben prejšnjemu:
    </p>
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
        Velikokrat je odlašanje v algorithmih brez pomena, saj moramo neko stvar narediti slej ko prej, vendar pri tej
        nalogi
        se pa časovna zahtevnost celo spremeni.
    </p>

    <p>
        Časovna zahtevnost je sedaj <b>O(log(n))</b> za vsako poizvedbo in posodobitev. To drevo je sposobno vsega, kar
        je sposobno
        tudi navadno segmentno drevo brez nekih omembe vrednih časovnih izgub.
    </p>

    <h1>Implementacija</h1>
    <p>Koda je precej podobna, a rahlo spremenjena.</p>
    <pre class="prettyprint">
typedef long long ll;

struct SegTree {
    int tree_size;
    ll* tree;
    int* lazy;
    SegTree(int size) {
        tree_size = 1;
        while(tree_size < size)
            tree_size *= 2;
        tree = new ll[2 * tree_size]();
        lazy = new int[2 * tree_size]();
    }

    void update(int node, int len);

    ll get(int node, int rl, int rr, int l, int r);

    ll get(int l, int r) {
        return get(1, 0, tree_size, l, r);
    }

    void add(int node, int rl, int rr, int l, int r, int x);

    void add(int l, int r, int x) {
        add(1, 0, tree_size, l, r, x);
    }
};</pre>
    <p>
        Koda je precej podobna, le da imamo sedaj še <b>lazy</b> tabelo, ki jo uporabljamo pri posodabljanju.
        Dodana je tudi funkcija <b>update</b>, ki posodobi vrednost <b>lazy</b> na vozlišču in ga potisne navzdol na
        otroka.
        Tudi funkcija set je spremenjena, saj zdaj posodabljamo intervale in ne več posameznih elementov.
    </p>

    <pre class="prettyprint">
void SegTree::update(int node, int len) {
    if(lazy[node] != 0) {
        if(node < tree_size) {
            lazy[2 * node] += lazy[node];
            lazy[2 * node + 1] += lazy[node];
        }
        tree[node] += 1LL * lazy[node] * len;
        lazy[node] = 0;
    }
}</pre>
    <p>
        Ta funkcija posodobi vrednost <b>lazy</b> na vozlišču in ga potisne navzdol na otroka.
        S tem poskrbi, da je vrednost <b>tree</b> na vozlišču pravilna.
        Najprej preverimo, če je vrednost <b>lazy</b> na vozlišču različna od 0, saj če je enaka 0, potem ni potrebe po
        posodabljanju.
        Drugi if stavek preveri, če je vozlišče list, saj če je, potem nima otrok in ne moremo posodobiti njihovih
        vrednosti.
        Na koncu posodobimo vrednost vozlišča in jo nastavimo <b>lazy</b> na 0.
    </p>
    <pre class="prettyprint">
ll SegTree::get(int node, int rl, int rr, int l, int r) {
    if(r <= rl || rr <= l)
        return 0;

    update(node, rr - rl);
    if(l <= rl && rr <= r)
        return tree[node];

    int mid = (rl + rr) / 2;
    return get(2 * node, rl, mid, l, r) + get(2 * node + 1, mid, rr, l, r);
}</pre>
    <p>
        Ta funkcija je precej podobna tisti iz navadnega segmentnega drevesa, le da moramo, preden nadaljujemo z
        iskanjem,
        poklical funkcijo <b>update</b>, ki poskrbi, da je vrednost <b>tree</b> na vozlišču pravilna.

    </p>
    <pre class="prettyprint">
void SegTree::add(int node, int rl, int rr, int l, int r, int x) {
    update(node, rr - rl);
    if(r <= rl || rr <= l)
        return;

    if(l <= rl && rr <= r) {
        lazy[node] += x;
        update(node, rr - rl);
        return;
    }

    int mid = (rl + rr) / 2;
    add(2 * node, rl, mid, l, r, x);
    add(2 * node + 1, mid, rr, l, r, x);
    tree[node] = tree[2 * node] + tree[2 * node + 1];
}</pre>
    <p>
        Ta funkcija je precej podobna funkciji <b>get</b>, saj naredita precej podobno stvar.
        Obe funkciji si izbereta segmente na isti način.
    </p>

</main>

</body>

</html>
