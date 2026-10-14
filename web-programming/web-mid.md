## HTML & CSS Mid practice


### summer26-q1

![Preview](/web-programming/sum-26/q1/q1.png)

[View HTML](/web-programming/sum-26/q1/q1.html) | [View CSS](/web-programming/sum-26/q1/q1.css)

---

### summer26-q2

![Preview](/web-programming/sum-26/q2/q2.png)

[View HTML](/web-programming/sum-26/q2/q2.html) | [View CSS](/web-programming/sum-26/q2/q2.css)

---

### spring26-slot1-q1

![Preview](/web-programming/sp26-s1/sp26-q1.png)

[View HTML](/web-programming/sp26-s1/sp26-q1.html) | [View CSS](/web-programming/sp26-s1/sp26-q1.css)

---

### spring26-slot1-q2

![Preview](/web-programming/sp26-s1/sp26-q2.png)

[View HTML](/web-programming/sp26-s1/sp26-q2.html) | [View CSS](/web-programming/sp26-s1/sp26-q2.css)

---

### spring26-slot2-q1

![Preview](/web-programming/sp26-s2/sp26-s2-q1.png)

[View HTML](/web-programming/sp26-s2/sp26-s2-q1.html) | [View CSS](/web-programming/sp26-s2/sp26-s2-q1.css)

---

### spring26-slot2-q2

![Preview](/web-programming/sp26-s2/sp26-s2-q2.png)

[View HTML](/web-programming/sp26-s2/sp26-s2-q2.html) | [View CSS](/web-programming/sp26-s2/sp26-s2-q2.css)

---

### summer25-q2

![Preview](/web-programming/sum-25/sum-25-q2.png)

[View HTML](/web-programming/sum-25/sum-25-q2.html) | [View CSS](/web-programming/sum-25/sum-25-q2.css)

---

### fall-25-q1

![Preview](/web-programming/fall-25/q1.png)

[View HTML](/web-programming/fall-25/q1.html) | [View CSS](/web-programming/fall-25/q1.css)

---

### fall-25-q1

![Preview](/web-programming/fall-25/q2.png)

[View HTML](/web-programming/fall-25/q2.html) | [View CSS](/web-programming/fall-25/q2.css)

---


## Web Design & CSS Cheatsheet


## 1. Outer Container Rounded Corners Covered by Children
* **Problem**: Parent has `border-radius: 8px;`, but child elements have background colors with sharp square corners covering the rounded corners.
* **Fix**: Add `overflow: hidden;` to the parent container.
```css
.card-container {
    border-radius: 8px;
    overflow: hidden; /* Clips child background colors flush to corners */
}
```

---

## 2. Avatar Circle Text Overflow (`padding` + `border-box` Trap)
* **Problem**: Text inside a `50px` circular avatar spills outside the circle.
* **Cause**: `padding: 15px` + `box-sizing: border-box` shrinks inner content space to just `20px × 20px`.
* **Fix**: Remove `.padding` from avatar, increase size (e.g. `70px`), and use `overflow: hidden` or flex centering:
```css
.avatar {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
```

### Centering Avatar Alone (Without Centering Whole Sidebar)
* **Problem**: Setting `align-items: center;` on parent `.g11` centers *all* sidebar menu links to the middle.
* **Fix**: Keep `.g11` default left-aligned, and apply `align-self: center;` to `.avatar`.
```css
.g11 {
    display: flex;
    flex-direction: column; /* Menu links stay left-aligned */
}

.avatar {
    align-self: center; /* Centers ONLY a single flex item */
}
```

---

## 3. `margin: 0 auto` vs `text-align: center` (`block` vs `inline-block`)

* **Cause**: `margin: 0 auto` only works on `display: block`. It **does not work** on `inline-block` or `inline` elements.
* **Fix**:
  - For `display: block`: Use `margin: 0 auto;` (requires a fixed `width`).
  - For `display: inline-block`: Use `text-align: center;` on the **parent container**.

---

## 4. Footer `box-shadow` Invisible?

* **Problem**: `box-shadow: 5px 7px 3px color;` casts shadow **downward** (`+7px`), pushing it off the bottom of the screen.
* **Fix**: Use a **negative Y offset** (`-5px`) to cast the shadow **upward** over the content, and give the element a solid `background-color`.
```css
.footer {
    background-color: white;
    box-shadow: 0px -5px 10px rgba(0, 0, 0, 0.15); /* Casts UPWARD */
}
```

---

## 5. CSS Gradients (Fades & Color Shifts)

* **Smooth Dark-to-Light Fade**:
```css
background: linear-gradient(to bottom, #0d3e86, #649beb);
```
* **Multi-Color Smooth Fade**:
```css
background: linear-gradient(45deg, #0d3e86, #6b63ff, #ea6aa8);
```
* **Hard / Solid Color Split (No Fade)**:
```css
background: linear-gradient(to right, #0d3e86 40%, #e9eff7 40%);
```

---

## 6. Speed Hacks for UI Design Exams

### Instant Checkboxes (Zero CSS Needed)
```html
<!-- Native checked input -->
<input type="checkbox" checked> Real-time collaboration

<!-- HTML Checkbox symbols -->
<div>☑ Real-time collaboration</div>
<div>✔ Advanced reporting tools</div>
```

### Form Input Styling (`width: 100%`)
Target input elements directly without needing classes on every HTML tag:
```css
input[type="text"],
input[type="email"],
input[type="password"],
input, button {
    width: 100%;         /* Fills full width of parent container */
    padding: 10px;       /* Adds height and spacing inside input */
    border-radius: 6px;  /* Smooth UI edges */
}
```

---

## 7. Flexbox & Stretching Layouts

### Expanding Flex Items (`flex: 1`)
When a child element inside a flex container needs to occupy all remaining horizontal or vertical space:
```css
.flex-container {
    display: flex;
    align-items: center;
}

.flex-left {
    /* takes up only as much width as its content */
}

.flex-right {
    flex: 1; /* Takes up ALL remaining horizontal space */
}
```

> [!TIP]
> If a progress bar or text block inside a flex container won't stretch, check if its parent has `flex: 1` or `flex-grow: 1`.

---

## 8. Pill / Capsule Badges

To make a dynamic pill/capsule tag (e.g., status badges like **"Design"**, **"Plan"**, **"In Progress"**):

```css
.capsule {
    display: inline-block;   /* Wraps tightly around text width */
    padding: 6px 16px;      /* Creates breathing room around text */
    border-radius: 50px;    /* Smooth pill curve (50px or 9999px) */
    font-size: 14px;
    font-weight: 500;
}
```

### Why Avoid Hardcoded `width` & `height` on Capsules?
* **Fixed `width: 60px; height: 40px;`** causes longer text to overflow or cut off.
* **`padding` + `display: inline-block`** lets the badge automatically resize for any text length.

---

## 9. Progress Bar Pattern

Progress bars consist of a track (gray bar) and a fill bar (progress bar):

```html
<div class="gray-bar radious">
    <div class="progress-bar color1 radious" style="width: 70%;"></div>
</div>
```

```css
.gray-bar {
    height: 10px;
    width: 100%;             /* Takes full width of parent container */
    background-color: #E0E0E0;
    border-radius: 16px;
    overflow: hidden;         /* Ensures inner bar doesn't overflow corners */
}

.progress-bar {
    height: 100%;
    border-radius: 16px;
    /* Controlled dynamically via inline style width: 70% */
}
```

---

## 10. CSS Cascade & Specificity Rules

### File Order (The Cascade)
When two class selectors have the **same specificity**, the rule written **LOWER** in the CSS file wins.

```css
/* Line 5 */
.color1 {
    background-color: #536FFE;
}

/* Line 180 */
.capsule {
    background-color: #C1CDFF; /* <--- THIS WINS because it's lower in the file */
}
```

---

## 11. Silent Deal-Breaker Bugs (Check First!)

1. **Filename / Link Mismatch**: Verify `<link rel="stylesheet" href="filename.css">` matches your CSS filename exactly.
2. **HTML vs CSS Class Mismatch**: Check class names (e.g., `class="grid1"` in HTML vs `.grid` in CSS).
3. **Debug with Red Outlines**:
```css
* { outline: 1px solid red; }
```
