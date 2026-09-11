# Algorithms


## 1. Recursion

```cpp
#include<bits/stdc++.h>
using namespace std;
#define nl "\n"

// Calculate the factorial of n
int factorial(int n) {
    // if we put return 0, fact(2) = 2 x 1 x 0 => 0
    if (n <= 0) return 1;

    return n * factorial(n-1);
}

// Print the numbers from 1 to n
void print(int n) {
    if (n <= 0) return;

    print(n-1);
    cout << n << " ";
}

// Calculate the sum from 1 to n
int sum(int n) {
    if (n <= 0) return 0;

    return n + sum(n-1);
}

// Calculate the sum of digits of a given number n
// digitSum(324) = 3+2+4 = 9
int digitSum(int n) {
    // if we put return 1, that will add 1 to res
    if (n == 0) return 0;

    return (n%10) + digitSum(n/10);
}

// Count the number of digits of a given number n
int numCount(int n) {
    if (n <= 0) return 0;

    return 1 + numCount(n/10);
}

// find b^n
int power(int b, int n) {
    if (n <= 0) return 1;

    return b * power(b, n-1);
}

// print array elements
void printArr(vector<int>& arr, int idx) {
    if (idx < 0) return;

    printArr(arr, idx-1);
    cout << arr[idx] << " ";
}

// Calculate the sum of array
int arrSum(vector<int>& arr, int idx) {
    if (idx < 0) return 0;

    return arr[idx] + arrSum(arr, idx-1);
}

// Find the largest element of a given array
int arrMax(vector<int>& arr, int idx) {
    if (idx < 0) return 0;

    return max(arr[idx], arrMax(arr, idx-1));
}

// A number n is a power of 4 if and only if
// (n > 0)  && can keep dividing by 4 and final result becomes exactly 1
bool powOF4(int n) {
    if (n == 1) return true;
    if (n <= 0 || n%4 != 0) return false;

    return powOF4(n/4);
}

int main() {
    int n; cout << "n: "; cin >> n; cout << nl;

    cout << "print(1 to " << n << "): "; print(n); cout << nl;
    cout << "sum(1 to " << n << "): " << sum(n) << nl;
    cout << n << "! = " << factorial(n) << nl;
    cout << "digitSum(" << n << "): " << digitSum(n) << nl;
    cout << "numCount(" << n << "): " << numCount(n) << nl;
    cout << "b=2, n=" << n << "; 2^" << n << " = " << power(2, n) << nl;

    vector<int> arr = {4, 6, 0, 2, 1, 7};
    cout << "printArr: "; printArr(arr, arr.size()-1); cout << nl;
    cout << "arrSum[4+6+0+2+1+7] = " << arrSum(arr, arr.size()-1) << nl;
    cout << "arrMax[4,6,0,2,1,7] = " << arrMax(arr, arr.size()-1) << nl;
    cout << "is n a power of 4? = " << powOF4(n) << nl;
}
```
<br>

## 2. Divide & Conquer

### 2.1.1 Max-Min (pair)

```cpp
#include <bits/stdc++.h>
#define nl "\n"
using namespace std;

pair<int, int> max_min(vector<int>& v, int st, int end) {
    //base case: one element
    if (st == end) {
        return {v[st], v[st]};
    }

    //base case: two elements
    if (st+1 == end) {
        if (v[st] > v[end])
            return {v[st], v[end]};
        else
            return {v[end], v[st]};
    }

    //divide
    int mid = (st+end)/2;
    pair<int, int> left = max_min(v, st, mid);
    pair<int, int> right = max_min (v, mid+1, end);

    //conquer
    pair<int, int> result;
    result.first = max(left.first, right.first);
    result.second = min(left.second, right.second);
    return result;
}

int main() {
    int n; cout << "Size: ";cin >> n;

    cout << "elements: ";
    vector<int> v(n);
    for (int i = 0; i < n; i++) {
        cin >> v[i];
    }

    pair<int, int> res = max_min(v, 0, n-1);
    cout << "Max: " << res.first << nl;
    cout << "Min: " << res.second << nl;
}
```

<br>


### 2.1.2 Max-Min (Structure)

```cpp
#include<bits/stdc++.h>
using namespace std;
#define nl "\n"

struct minmax {
    int max, min;
};

struct minmax findMinMax(vector<int>& v, int st, int end) {
    struct minmax result;

    // base case: only one element
    if (st == end) {
        result.max = v[st];
        result.min = v[st];
        return result;
    }

    // base case: only two elements
    if (st+1 == end) {
        if (v[st] >= v[end]) {
            result.max = v[st];
            result.min = v[end];
        } else {
            result.max = v[end];
            result.min = v[st];
        }
        return result;
    }

    int mid = (st+end)/2;
    struct minmax left = findMinMax(v, st, mid);
    struct minmax right = findMinMax(v, mid+1, end);

    result.max = (left.max > right.max) ? left.max : right.max;
    result.min = (left.min < right.min) ? left.min : right.min;

    return result;
}

int main() {
    int n; cout << "size: "; cin >> n;
    vector<int> v(n);
    cout << "elements: ";
    for (int i = 0; i < n; i++) cin >> v[i];

    struct minmax res = findMinMax(v, 0, v.size()-1);
    cout << "max: " << res.max << nl;
    cout << "min: " << res.min << nl;
}
```

<br>


### 2.2 Maximum Subarray Sum

```cpp
#include<bits/stdc++.h>
#define nl "\n"
using namespace std;

int cross_subArr_sum(vector<int>& v, int st, int mid, int end) {
    int l_sum = INT_MIN;
    int r_sum = INT_MIN;

    int sum = 0;
    for (int i = mid; i >= st; i--) {
        sum += v[i];
        l_sum = max(l_sum, sum);
    }

    sum = 0;
    for (int i = mid+1; i <= end; i++) {
        sum+= v[i];
        r_sum = max(r_sum, sum);
    }

    return l_sum + r_sum;
}

int max_subArr_sum(vector<int>& v, int st, int end) {
    // base case: single element
    if (st == end) {
        return v[st];
    }

    int mid = (st+end)/2;
    int l_sum = max_subArr_sum(v, st, mid);     //left half
    int r_sum = max_subArr_sum(v, mid+1, end);  //right half
    int cross_sum = cross_subArr_sum(v, st, mid, end);

    return max(max(l_sum, r_sum), cross_sum);
}

int main() {
    int n; cout << "n: "; cin >> n;
    vector<int> v(n);
    cout << "elements: ";
    for (int i = 0; i < n; i++) {
        cin >> v[i];
    }

    int max_sum = max_subArr_sum(v, 0, v.size()-1);
    cout << "max subArr sum: " << max_sum << nl;
}
```

<br>


### 2.3 Merge Sort

```cpp
#include<bits/stdc++.h>
#define nl "\n"
using  namespace std;

void merge(vector<int>& v, int st, int mid, int end) {
    vector<int> tmp;
    int i = st;
    int j = mid+1;

    while (i <= mid && j <= end) {
        if (v[i] <= v[j]) {
            tmp.push_back(v[i]);
            i++;
        } else {
            tmp.push_back(v[j]);
            j++;
        }
    }

    while (i <= mid) {
        tmp.push_back(v[i]);
        i++;
    }

    while (j <= end) {
        tmp.push_back(v[j]);
        j++;
    }

    for (int idx = 0; idx < tmp.size(); idx++) {
        v[idx+st] = tmp[idx];
    }
}

void mergeSort(vector<int>& v, int st, int end) {
    if (st == end) {
        return;
    }

    int mid = (st+end)/2;
    mergeSort(v, st, mid);    // left half
    mergeSort(v, mid+1, end);  //right half

    merge(v, st, mid, end);
}

int main() {
    int n; cout << "n: "; cin >> n;
    vector<int> v(n);
    cout << "elements: ";
    for(int i = 0; i < n; i++) {
        cin >> v[i];
    }

    mergeSort(v, 0, v.size()-1);

    cout << "Sorted Arr: ";
    for (int val : v) {
        cout << val << " ";
    } cout << nl;
}
```


<br>


### 2.4 Quick Sort

```cpp
#include<bits/stdc++.h>
#define nl "\n"
using namespace std;

int partition(vector<int>& v, int st, int end) {
    int smaller = st-1;  // tracks values <= pivot
    int larger = st;     // tracks values >  pivot
    int pivot = v[end];  // we choose last elemet as pivot

    for ( ; larger < end; larger++) {
        // ascending:  v[larger] <= pivot
        // descending: v[larger] >= pivot
        if (v[larger] <= pivot) {
            smaller++;
            swap(v[larger], v[smaller]);
        }
    }

    smaller++;
    swap(v[end], v[smaller]);

    // smaller now contains the pivot index
    return smaller;
}

void quickSort(vector<int>& v, int st, int end) {
    if (st < end) {
        int pvt_idx = partition(v, st, end);

        quickSort(v, st, pvt_idx-1);    //left half
        quickSort(v, pvt_idx+1, end);   //right half
    }
}

int main() {
    int n; cout << "n: "; cin >> n;
    vector<int> v(n);
    cout << "elements: ";
    for (int i = 0; i < n; i++) {
        cin >> v[i];
    }

    quickSort(v, 0, v.size()-1);

    cout << "sorted: ";
    for (int val: v) {
        cout << val << " ";
    } cout << nl;
}
```

<br>


## 3. Greedy Algorithms

### 3.1 Fractional Knapsack

```cpp
// fractional knapsack greedy algorithm
#include <bits/stdc++.h>
using namespace std;
#define nl "\n"

struct item {
    double weight;
    double cost;
};

bool comp(item i1, item i2) {
    double i1_unit_price = i1.cost/i1.weight;
    double i2_unit_price = i2.cost/i2.weight;

    return i1_unit_price > i2_unit_price;
}

int main() {
    // given weight and cost of items
    vector<double> weight = {30,20,10};
    vector<double> cost   = {120,100,60};

    vector<item> items;
    for (int i = 0; i < weight.size(); i++) {
        struct item  it;

        it.weight = weight[i];
        it.cost = cost[i];
        items.push_back(it);
    }

    sort(items.begin(), items.end(), comp);

    double max_profit = 0;
    double max_cap = 50;
    for (const item& it: items) {
        if (it.weight <= max_cap) {
            // take the whole item
            max_cap -= it.weight;
            max_profit += it.cost;
        } else {
            int rem_weight = max_cap;
            max_profit += (it.cost/it.weight) * rem_weight;
            max_cap = 0;
            break;
        }
    }

    cout << "max profit: " << max_profit << nl;
}
```


<br>


### 3.2 Activity Selection

```cpp
#include<bits/stdc++.h>
using namespace std;
#define nl "\n"

struct activity {
    string name;
    int st_time;
    int fin_time;
};

bool comp(activity a1, activity a2) {
    return a1.fin_time < a2.fin_time;
}

int main() {
    // given start and end time of activity
    vector<int>  start = {3,0,5,8,5,1};
    vector<int> finish = {4,6,7,9,9,2};

    vector<activity> actV;
    for (int i = 0; i < start.size(); i++) {
        struct activity a;
        a.name = "a" + to_string(i);
        a.st_time = start[i];
        a.fin_time = finish[i];
        actV.push_back(a);
    }

    sort(actV.begin(), actV.end(), comp);

    int cur_time = -1;
    cout << "name | st | fin" << nl;
    cout << "-----+----+----" << nl;
    for (activity a : actV) {
        // Start time must be at least 1 hour after last selected activity
        if (a.st_time >= cur_time+1) {
            cout << " " + a.name << "  | " << a.st_time << "  |  "
                << a.fin_time << " " << nl;

            cur_time = a.fin_time;
        }
    }
}
```

<br>


## 4. Graph Algorithm

### 4.1 Kruskal (MST)

```cpp
#include<bits/stdc++.h>
using namespace std;
#define nl "\n"

int Find(int x, vector<int>& parent) {
    if (parent[x] == -1) return x;

    // return Find(parent[x], parent);
    return parent[x] = Find(parent[x], parent);     // path compression
}

void Union(int u, int v, vector<int>& parent, vector<int>& rank) {
    int rootU = Find(u, parent);
    int rootV = Find(v, parent);

    // we dont have to check here as we  already checked from main, but whatever :)
    if (rootU == rootV) return;    

    if (rank[rootU] > rank[rootV]) {
        parent[rootV] = rootU;
        rank[rootU] += rank[rootV];
    } else {
        parent[rootU] = rootV;
        rank[rootV] += rank[rootU];
    }
}

bool comp(vector<int>& a, vector<int>& b) {
    return a[2] < b[2];     // sorts based on weight
}

int main() {
    int V, E;
    cout << "num of vertices: "; cin >> V;
    cout << "num of edges   : "; cin >> E;

    // here we store the edges; cause kruskal works as random trees of forest
    // kruskal choose the edge with smallest weight and make random trees of forrest at fisrt
    // Dijkstra → Adjacency List (needs neighbors of a node frequently)
    // Bellman-Ford → Edge List (needs to scan all edges repeatedly)
    // Kruskal → Edge List (sort all edges)
    // Prim → Adjacency List (grow from a node to neighbors)
    vector<vector<int>> edgeList;
    for (int i = 0; i < E; i++) {
        cout << "u, v, w: ";
        int u, v, w;
        cin >> u >> v >> w;     

        edgeList.push_back({u,v,w});   
    }

    // default sorting sorts based lexicographically
    // sorts based on first element, if 1st el same, check 2nd
    sort(edgeList.begin(), edgeList.end(), comp);

    vector<int> parent(V, -1);     // init parent with -1 means, everyone is their own parent
    vector<int> rank(V, 1);        // rank defines the size of tree here, so everyone is at size=1 at first 

    int mstCost = 0;
    int edgeCount = 0;
    
    for (auto edge: edgeList) {
        int u = edge[0];
        int v = edge[1];
        int w = edge[2];

        // both of them cant have same parent
        if (Find(u, parent) != Find(v, parent)) {
            Union(u, v, parent, rank);

            mstCost += w;
            edgeCount++;

            cout << u << "-" << v << " (" << w << ")" << nl;
        }

        if (edgeCount == V-1) break;
    }

    cout << "mst cost = " << mstCost << nl;
}
```

<br>

### 4.2 Dijkstra (Shortest Path)

```cpp
#include<bits/stdc++.h>
using namespace std;
#define nl "\n"

int main() {
    int V, E;
    cout << "num of Vertices: "; cin >> V;
    cout << "num of edges   : "; cin >> E;
    
    // Dijkstra → Adjacency List (needs neighbors of a node frequently)
    // Bellman-Ford → Edge List (needs to scan all edges repeatedly)
    // Kruskal → Edge List (sort all edges)
    // Prim → Adjacency List (grow from a node to neighbors)
    vector<vector<pair<int, int>>> graph(V);    // adjacency List
    for (int i = 0; i < E; i++) {
        int u,v,w; cout << "u,v,w: "; cin >> u >> v >> w;
        
        /// directed graph
        graph[u].push_back({v,w});      

        /// undirected graph
        // graph[u].push_back({v,w});
        // graph[v].push_back({u,w});
    }

    // source node of the graph
    int src; cout << "src: "; cin >> src;

    // distance array
    vector<int> dist(V, INT_MAX);
    dist[src] = 0;

    // priority_queue<int> pq;                                 // max-heap(default)
    // priority_queue<int, vector<int>, greater<int>> pq;      // min-heap(flipped)
    //                 |        |          |
    //               type,  container,   flip

 
    // min-heap: {distance, node}
    priority_queue< pair<int,int>, vector<pair<int,int>>, greater<pair<int,int>> > pq;
    pq.push({0, src});

    while (!pq.empty()) {
        auto [d, u] = pq.top();
        pq.pop();

        // skip outdated entries
        if (d > dist[u]) continue;

        for (auto [v, w]: graph[u]) {

            if (dist[u]+w < dist[v]) {
                dist[v] = dist[u] + w;
                pq.push({dist[v], v});
            }
        }
    }

    cout << "shortest distance from " <<  src << nl;
    for (int i = 0; i < V; i++) {
        if (dist[i] == INT_MAX) 
            cout << src << " -> " << i << " : INF " << nl;
        else 
            cout << src << " -> " << i << " : " << dist[i] << nl;
    }
}


// steps: 
// input V,E
// input adj List for storing  graph
// take source node
// input distance array and init dist[src]=0
// PQ
// pop least distance node and relax edges if possible
//      - if possible push the new node in PQ
//      - discard outdated entries {d > dist[u]} 


// dijkstra pseudo code: 
// --------------------
//
// Input graph
//
// dist[] = INF
// dist[source] = 0
//
// push (0, source) into PQ
// while PQ is not empty:
//     (d, u) = node with smallest distance
//     if d > dist[u]
//         continue
//
//     for every neighbor (v,w) of u:
//         if dist[u] + w < dist[v]
//             dist[v] = dist[u] + w
//             push (dist[v], v) into PQ
```

<br>

### 4.3 Bellman Ford (Shortest Path)

```cpp
#include<bits/stdc++.h>
using namespace std;
#define nl "\n"

int main() {
    int V, E;
    cout << "num of Vertices: "; cin >> V;
    cout << "num of Edges   : "; cin >> E;

    // Dijkstra → Adjacency List (needs neighbors of a node frequently)
    // Bellman-Ford → Edge List (needs to scan all edges repeatedly)
    // Kruskal → Edge List (sort all edges)
    // Prim → Adjacency List (grow from a node to neighbors)
    vector<vector<int>> edgeList;
    for (int i = 0; i < E; i++) {
        int u,v,w;
        cout << "u,v,w: "; 
        cin >> u >> v >> w;

        edgeList.push_back({u,v,w});
    }
    
    int src; cout << "src node: "; cin >> src;
    vector<int> dist(V, INT_MAX);   // INT_MAX -> initially all nodes are unreachable
    dist[src] = 0;

    // bellman ford relax edges  at max (V-1) times
    // but we'll do just one more time for neg cycle detection
    for (int i = 1; i <= V; i++) {
        
        for (auto edge: edgeList) {
            int u = edge[0];
            int v = edge[1];
            int w = edge[2];

            if (dist[u]==INT_MAX) continue;     // unreachable

            if (dist[u]+w < dist[v]) {

                // check for neg cycle
                if (i == V) {
                    cout << "neg cycle detected" << nl;
                    break;
                }

                // relax edges
                dist[v] = dist[u] + w;
            }
        }
    }

    cout << "shortest distance from: " << nl; 
    for (int i = 0; i < V; i++) {
        cout << src << "->" << i << "=" << dist[i] << nl;
    }
}


// steps:
// input V,E
// input edgeList to store edges
// input src 
// input distance array & dist[src]=0
// iterate 'V' times 
//      - (V-1) for Bellman-Ford
//      - +1 for neg cycle detection
//      - relax edges


// bellman-ford pseudo code:
// ------------------------
// dist[] = INF
// dist[src] = 0
//
// repeat (V-1) times:
//     for each edge (u,v,w) from edgeList
//         if dist[u] is reachable
//             if dist[u] + w < dist[v]
//                 dist[v] = dist[u] + w

// Then for negative cycle detection:
//     for each edge (u,v,w)
//         if dist[u] + w < dist[v]
//             Negative Cycle Exists
```

<br>

## 5. Dynamic Programming

### 5.1 0/1 Knapsack

```cpp
```

### 5.2 Coin Change

```cpp
```
