<!DOCTYPE html>
<html lang="en">

<?php require("head.php"); ?>

<body>

<?php require("menu.php"); ?>

<main>

    <p>
        Denimo, da imamo nov problem, ki je spet samo razširitev prejšnjega:
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

        <p>
            Vendar tokrat je seznam lahko zelo dolg - do <b>10<sup>9</sup></b> elementov.
        </p>
    </div>

    <p>
        Ugotovimo, da če bi zdradili drevo na enak način kot prej, bi bilo drevo preveliko in ne bi imeli dovolj spomina
        ali časa.
        Vendar dobimo idejo: Kaj pa če namesto celega drevesa shranimo samo tista vozlišča, ki so pomembna?
        Bolj natančno bi shranili samo tista vozlišča, ki so bila kadarkoli spremenjena. Vsako vozlišče bi imelo dva
        kazalca na otroka,
        ki bi bila <b>-1</b>, če otroka ne bi bilo. V tem primeru je cel interval, ki ga to vozlišče predstavlja, enak
        <b>0</b>.
    </p>

    <img src="static/segmentno_drevo_3.png" alt="binarno drevo">
    <p>
        Tako bi izgledalo redko drevo, če bi samo posodobili označena intervala.
        Celo drevo je narisano s sivo barvo, redko drevo pa s črno.
    </p>

    <h1>Implementacija</h1>
    <pre class="prettyprint">
#include &lt;vector&gt;
using namespace std;
typedef long long ll;

struct SegTree {
    int tree_size;
    vector<ll>tree;
    vector<int>lazy;
    vector<int>c1;
    vector<int>c2;
    SegTree(int size) {
        tree_size = 1;
        while(tree_size < size)
            tree_size *= 2;
        tree.push_back(0);
        lazy.push_back(0);
        c1.push_back(-1);
        c2.push_back(-1);
    }

    int new_node();

    void update(int node, int len);

    ll get(int node, int rl, int rr, int l, int r);

    ll get(int l, int r) {
        return get(0, 0, tree_size, l, r);
    }

    int add(int node, int rl, int rr, int l, int r, int x);

    void add(int l, int r, int x) {
        add(0, 0, tree_size, l, r, x);
    }
};</pre>

    <p>
        Tukaj imamo zdaj <b>vector</b>, saj bomo dinamično dodajali vozlišča.
        <b>c1</b> in <b>c2</b> sta kazalca na indeksa otrok. Če je kazalec <b>-1</b>, potem otroka ni.
        Koren drevesa je na indeksu <b>0</b> in je nastavljen v konstruktorju.
    </p>

    <pre class="prettyprint">
int SegTree::new_node() {
    tree.push_back(0);
    lazy.push_back(0);
    c1.push_back(-1);
    c2.push_back(-1);
    return (int)tree.size() - 1;
}
</pre>
    <p>
        Funkcija <b>new_node</b> doda novo vozlišče v drevo in vrne njegov indeks.
    </p>

    <pre class="prettyprint">
void SegTree::update(int node, int len) {
    if(lazy[node] != 0) {
        if(c1[node] == -1)
            c1[node] = new_node();
        lazy[c1[node]] += lazy[node];

        if(c2[node] == -1)
            c2[node] = new_node();
        lazy[c2[node]] += lazy[node];

        tree[node] += 1LL * lazy[node] * len;
        lazy[node] = 0;
    }
}</pre>

    <p>
        Ta funkcija je podobna kot prej, le da moramo zdaj paziti, da bomo ustvarili novega otroka, če ga še ni.
    </p>

    <pre class="prettyprint">
ll SegTree::get(int node, int rl, int rr, int l, int r) {
    if(r <= rl || rr <= l || node == -1)
        return 0;

    update(node, rr - rl);
    if(l <= rl && rr <= r)
        return tree[node];

    int mid = (rl + rr) / 2;
    return get(c1[node], rl, mid, l, r) + get(c2[node], mid, rr, l, r);
}</pre>

    <p>
        Ta funkcija je tudi skoraj enaka, le da moramo paziti, da ne bomo šli v vozlišče, ki ne obstaja.
        Tudi treba je biti pozoren na to, da otroci niso več <b>2 * node</b> in <b>2 * node + 1</b>, ampak so shranjeni
        v tabeli.
    </p>


    <pre class="prettyprint">
int SegTree::add(int node, int rl, int rr, int l, int r, int x) {
    if(node == -1)
        node = new_node();
    update(node, rr - rl);

    if(r <= rl || rr <= l)
        return node;

    if(l <= rl && rr <= r) {
        lazy[node] += x;
        update(node, rr - rl);
        return node;
    }

    int mid = (rl + rr) / 2;
    c1[node] = add(c1[node], rl, mid, l, r, x);
    c2[node] = add(c2[node], mid, rr, l, r, x);
    tree[node] = tree[c1[node]] + tree[c2[node]];
    return node;
}</pre>

    <p>
        Tukaj funkcija vrne indeks vozlišča, ki ga je spremenila.
        Če je vozlišče <b>-1</b>, potem ga ustvari, v nasprotnem primeru pa samo vrne isti indeks.
    </p>

</main>

</body>

</html>
