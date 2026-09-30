# 🛡️ MediVault Project Structure & Interview Cheat Sheet

## 1. Tech Stack Summary
- **Frontend Framework**: Svelte 5 / SvelteKit (UI built using `.svelte` files and file-based routing)
- **Backend & Database**: Convex (Real-time reactive backend and database schema defined in TypeScript)
- **Styling**: Tailwind CSS v4 + UI Components (`bits-ui`, Lucide icons)
- **Runtime & Tools**: Bun & Vite

---

## 2. Global vs. Local UI Elements (What's the difference?)

### 🌐 Global & Common UI Elements
**"Global"** means styling or UI components that affect **the entire website or multiple pages at once**.
- **Global CSS ([src/app.css](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/src/app.css))**: If you change the background color or font here, **every single page** changes.
- **Root Layout ([src/routes/+layout.svelte](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/src/routes/%2Blayout.svelte))**: Surrounds all pages. Contains things that must exist on every route (like global toast notifications, global context providers, dark mode script).
- **Reusable UI Components ([src/lib/components/ui](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/src/lib/components/ui))**: Buttons, Cards, Dialogs/Modals, Inputs. Editing `Button.svelte` changes how *all buttons across the app* look.

### 📍 Local UI Elements
**"Local"** means UI elements that **only belong to ONE specific page**.
- Example: The "Reserve Medicine" button or the search bar on the Pharmacy page is local to `src/routes/(app)/pharmacy/+page.svelte`. Changing code there **will not affect** any other page.

---

## 3. Simplified Answer: "Where is Server Routing & Authentication Protection Enforced?"

### In plain English:
> *"How does the website check if a user is logged in, and stop unauthorized people from seeing private pages?"*

It happens in **two main places**:

1. **Step 1: Checking the User's ID / Cookie (Global Security Guard)**
   - **File**: [src/hooks.server.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/src/hooks.server.ts)
   - **What it does**: On *every single browser request*, this script looks at the user's browser cookie. It asks Convex backend: *"Is this session token valid?"*. If yes, it attaches `user` information to the request so the app knows who you are.

2. **Step 2: Protecting Specific Pages / Role-Based Redirects (Door Bouncer)**
   - **File**: [src/routes/(app)/+layout.server.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/src/routes/%28app%29/%2Blayout.server.ts) (also `(admin)/+layout.server.ts` and `(pharmacist)/+layout.server.ts`)
   - **What it does**: Before rendering any page inside `(app)`, it checks:
     - Is the user logged in? If NOT $\rightarrow$ Redirect to `/login`.
     - Is an Admin trying to view customer dashboard? $\rightarrow$ Redirect them to `/admin`.

---

## 4. "Which File Do I Edit To Change...?" Quick Reference

### 🎨 Global UI & Styling
| What to change | File Location |
| :--- | :--- |
| Overall website fonts, colors, theme variables | [src/app.css](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/src/app.css) |
| Root HTML template & page metadata | [src/app.html](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/src/app.html) |
| Common UI Buttons, Cards, Badges, Modals | [src/lib/components/ui/](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/src/lib/components/ui) |

### 👤 User Pages `(app)`
| Page / UI Section | Frontend File (`.svelte`) | Backend File (`convex/`) |
| :--- | :--- | :--- |
| Sidebar Navigation / User Layout | [src/routes/(app)/+layout.svelte](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/src/routes/\(app\)/%2Blayout.svelte) | - |
| Patient Dashboard | `src/routes/(app)/dashboard/+page.svelte` | [convex/reservations.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/reservations.ts) |
| Pharmacy Search & Medicines | `src/routes/(app)/pharmacy/+page.svelte` | [convex/medicines.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/medicines.ts) |
| AI Medical Assistant Chat | `src/routes/(app)/ai-assistant/+page.svelte` | [convex/rag.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/rag.ts) |
| Prescriptions Page | `src/routes/(app)/prescriptions/+page.svelte` | [convex/prescriptions.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/prescriptions.ts) |
| Reservations List | `src/routes/(app)/reservations/+page.svelte` | [convex/reservations.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/reservations.ts) |
| Customer Complaints / Feedback | `src/routes/(app)/complaint/+page.svelte` | [convex/complaints.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/complaints.ts) |

### 🔒 Auth, Admin & Pharmacist
| Feature | Page UI | Backend File |
| :--- | :--- | :--- |
| Login & Register UI | `src/routes/(auth)/login/+page.svelte` | [convex/auth.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/auth.ts) |
| Admin Panel | `src/routes/(admin)/...` | [convex/admin.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/admin.ts) |
| Pharmacist Panel | `src/routes/(pharmacist)/...` | [convex/medicines.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/medicines.ts) |

---

## 5. Top Interview Questions You Might Be Asked (with Non-Dev Friendly Answers!)

### Q1: "If I want to add a new table or add a new field (like `phone_number` to user profile) in the database, where do I do that?"
- **Answer**: 
  1. Open [convex/schema.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/schema.ts) and add `phone_number: v.optional(v.string())` to the `users` table schema.
  2. Update the backend user function in [convex/users.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/users.ts).
  3. Update the UI input field in `src/routes/(app)/profile/+page.svelte`.

### Q2: "How does data flow from the database to the screen?"
- **Answer**: 
  1. Convex database holds data.
  2. A Convex backend query (e.g. `getMedicines` in [convex/medicines.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/medicines.ts)) fetches or filters it.
  3. The Svelte page (`pharmacy/+page.svelte`) subscribes to that query using `useQuery()`.
  4. If database data changes, Convex automatically updates the screen in real-time without refreshing!

### Q3: "What happens when a user clicks 'Login'?"
- **Answer**:
  1. User submits form on `src/routes/(auth)/login/+page.svelte`.
  2. The page calls backend authentication function in [convex/auth.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/auth.ts).
  3. Backend verifies password, generates a session cookie token.
  4. Cookie is saved in the browser and user gets redirected to `/dashboard`.

### Q4: "Where are environment variables / secret keys stored?"
- **Answer**: In `.env.local` file (e.g. Convex deployment URL, API keys).

---

### 🚀 Quick Command Checklist
- Run frontend dev server: `bun run dev`
- Run Convex backend dev server: `npx convex dev`
