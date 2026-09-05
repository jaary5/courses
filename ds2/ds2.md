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

## 4. Graph Algorithm

### 4.1 Kruskal (MST)

```cpp
```

### 4.2 Dijkstra (Shortest Path)

```cpp
```

### 4.3 Bellman Ford (Shortest Path)

```cpp
```

## 5. Dynamic Programming

### 5.1 0/1 Knapsack

```cpp
```

### 5.2 Coin Change

```cpp
// Coin Change code
```
