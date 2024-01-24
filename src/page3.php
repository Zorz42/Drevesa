<!DOCTYPE html>
<html lang="en">

<?php require("head.php"); ?>

<body>

<?php require("menu.php"); ?>

<main>

    Denimo, da imamo nov problem, ki je spet samo razširitev prejšnjega:
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
        Ugotovimo, da če bi zdradili drevo na enak način kot prej, bi bilo drevo preveliko in ne bi imeli dovolj spomina ali časa.
        Vendar dobimo idejo: Kaj pa če namesto celega drevesa shranimo samo tista vozlišča, ki so pomembna?
        Bolj natančno bi shranili samo tista vozlišča, ki so bila kadarkoli spremenjena. Vsako vozlišče bi imelo dva kazalca na otroka,
        ki bi bila <b>-1</b>, če otroka ne bi bilo. V tem primeru je cel interval, ki ga to vozlišče predstavlja, enak <b>0</b>.
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
    ll get_val(int node);

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

</main>

</body>

</html>
