# 🎓 MediVault Technical Architecture & CS Interview Guide

## 1. High-Level Architecture & Tech Stack Overview
MediVault is built on a modern **BaaS (Backend-as-a-Service)** decoupled architecture using **SvelteKit** for server-side rendering/routing and **Convex** as a real-time reactive database and serverless backend.

- **Frontend**: **Svelte 5** (utilizing Svelte 5 Runes `$state`, `$derived`, `$props`) with **SvelteKit** (file-based routing system).
- **Backend & Database**: **Convex** (ACID-compliant document database with WebSockets-based real-time reactivity).
- **Reactivity Client**: `ConvexClient` from `convex/browser` ([src/lib/convexClient.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/src/lib/convexClient.ts)) subscribing via `convex.onUpdate(...)` and executing mutations via `convex.mutation(...)`.
- **Authentication**: Custom HTTP-only session cookie tokens backed by Convex sessions table, verified globally at the SvelteKit request hook level (`hooks.server.ts`).
- **Styling**: Tailwind CSS v4 + `bits-ui` / `shadcn-svelte` primitive components.
- **Runtime**: Bun & Vite.

---

## 2. Server Routing & Authentication Architecture
> **Interview Question**: *"Where and how is server routing and authentication enforced in this SvelteKit project?"*

### **Technical Breakdown**:
Authentication in this codebase operates via a **2-Layer Guard Pattern**:

#### **Layer 1: Global Middleware Hook ([src/hooks.server.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/src/hooks.server.ts))**
- Intercepts **every incoming HTTP request** at the server boundary before page rendering (`Handle` function signature).
- Extracts the HTTP-only `SESSION_COOKIE` from `event.cookies`.
- Queries Convex backend via Node HTTP client (`convexServer.query(api.auth.getSession, { token })`).
- If valid, populates `event.locals.user` with user session payload (`SessionUser`). If invalid/expired, clears the cookie via `clearSessionCookie(event.cookies)`.

#### **Layer 2: Layout Guards & Role-Based Access Control (RBAC)**
- Enforced in server load functions:
  - `(app)/+layout.server.ts`: Uses `requireUser(locals.user, url)`. Restricts customer-only routes (`/dashboard`, `/reservations`, `/prescriptions`) away from non-customer roles via `redirect(303, roleHome(user.role))`.
  - `(admin)/+layout.server.ts` & `(pharmacist)/+layout.server.ts`: Verify that `locals.user.role === 'admin'` or `'pharmacist'` respectively; throws HTTP `303 Redirect` or HTTP `403 Forbidden` if unauthorized.

---

## 3. Global vs. Local Scope & Architecture

### **Global Scope (App-wide Cross-Cutting Concerns)**
- **Global Design Tokens / Styles**: [src/app.css](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/src/app.css) defines Tailwind v4 theme variables, CSS custom properties (`--background`, `--primary`, `--radius`), and dark mode colors.
- **Root Layout Shell ([src/routes/+layout.svelte](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/src/routes/%2Blayout.svelte))**: Wraps the entire component tree. Instantiates global toast context (`<Toaster />`), theme providers (`<ModeWatcher />`), and top-level slot loading.
- **Design System UI Primitives ([src/lib/components/ui](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/src/lib/components/ui))**: Atomic components (`Button.svelte`, `Input.svelte`, `Dialog.svelte`) wrapped over `bits-ui`. Modifying `Button.svelte` changes atomic styling globally.

### **Local Scope (Feature & Route Encapsulation)**
- **Page Views (`+page.svelte`)**: Route-specific HTML structure, local reactive state (`let state = $state()`), and localized event handlers.
- **Feature Components ([src/lib/components/shared](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/src/lib/components/shared))**: Domain-specific UI elements like `PharmacyCard.svelte` or `PrescriptionCard.svelte` used specifically within local feature modules.

---

## 4. Full Component & Route File Mapping Matrix

| Feature Domain | UI View Route (`.svelte`) | Server Load / Guard | Backend Convex Handler | Database Tables (`schema.ts`) |
| :--- | :--- | :--- | :--- | :--- |
| **Authentication** | `src/routes/(auth)/login/+page.svelte`<br>`src/routes/(auth)/register/+page.svelte` | `(auth)/+layout.server.ts` | [convex/auth.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/auth.ts) | `users`, `sessions` |
| **User Layout & Sidebar** | [src/routes/(app)/+layout.svelte](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/src/routes/\(app\)/%2Blayout.svelte) | `(app)/+layout.server.ts` | [convex/users.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/users.ts) | `users` |
| **Pharmacy & Medicine Catalog** | `src/routes/(app)/pharmacy/+page.svelte` | - | [convex/medicines.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/medicines.ts) | `medicines`, `pharmacies` |
| **Medicine Reservations** | `src/routes/(app)/reservations/+page.svelte` | - | [convex/reservations.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/reservations.ts) | `reservations`, `reservationItems` |
| **Prescription Vault** | `src/routes/(app)/prescriptions/+page.svelte` | - | [convex/prescriptions.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/prescriptions.ts) | `prescriptions` |
| **AI Assistant (RAG Chat)** | `src/routes/(app)/ai-assistant/+page.svelte` | - | [convex/rag.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/rag.ts) | `ai_messages`, `vector_index` |
| **Complaints & Feedback** | `src/routes/(app)/complaint/+page.svelte` | - | [convex/complaints.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/complaints.ts) | `complaints` |
| **Admin Control Panel** | `src/routes/(admin)/+page.svelte` | `(admin)/+layout.server.ts` | [convex/admin.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/admin.ts) | `users`, `system_logs` |
| **Pharmacist Workstation** | `src/routes/(pharmacist)/+page.svelte` | `(pharmacist)/+layout.server.ts` | [convex/medicines.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/medicines.ts) | `reservations`, `medicines` |

---

## 5. Technical Questions & CS Undergrad Level Answers

### **Q1: How does state management and real-time data sync work between the Convex backend and Svelte 5 frontend?**
> **Answer**: 
> "The frontend instantiates a singleton `ConvexClient` in [src/lib/convexClient.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/src/lib/convexClient.ts) connected over a persistent WebSocket connection to Convex cloud. 
> 
> In Svelte components (e.g. `pharmacy/+page.svelte`), we subscribe to Convex queries using `convex.onUpdate(api.users.listPharmacies, {}, (data) => { ... })` inside lifecycle hooks (`onMount`). We assign the incoming payload to a Svelte 5 **Rune** `$state` variable (`let pharmaciesList = $state([])`). 
> 
> When database records mutate in Convex (`convex/medicines.ts`), Convex pushes a delta diff over WebSockets to subscribed clients, updating the `$state` variable. Svelte 5's fine-grained reactivity graph automatically recalculates `$derived` expressions and triggers DOM re-renders without full page refreshes."

---

### **Q2: Where is the database schema defined, and how do you execute schema migrations or additions?**
> **Answer**:
> "Database schemas are defined programmatically using TypeScript in [convex/schema.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/schema.ts) using Convex's `defineSchema` and `defineTable` constructs with runtime type validators `v.string()`, `v.id()`, `v.number()`, etc.
> 
> To add a field or table:
> 1. We update `schema.ts` (e.g. adding `status: v.union(v.literal("pending"), v.literal("completed"))`).
> 2. Convex automatically generates updated TypeScript definitions into `convex/_generated/api.d.ts` and `dataModel.d.ts`.
> 3. Backend mutations/queries in `convex/*.ts` leverage type-safe context (`ctx.db.insert(...)`, `ctx.db.query(...)`)."

---

### **Q3: Explain the request-response lifecycle of an authenticated route in SvelteKit.**
> **Answer**:
> 1. **Client Request**: Browser sends an HTTP GET request to `/dashboard` with session cookies.
> 2. **Server Middleware**: `hooks.server.ts` executes `handle()`, extracts the session cookie, queries Convex to validate the session token, and populates `event.locals.user`.
> 3. **Layout Server Load**: SvelteKit executes `(app)/+layout.server.ts` `load()` function. It reads `locals.user`. If null or unauthorized for route `/dashboard`, it calls `redirect(303, '/login')`.
> 4. **Page SSR & Hydration**: If authorized, data resolves, server renders HTML, and streams it to the client where client-side JavaScript hydrates the Svelte 5 reactive tree.

---

### **Q4: How are mutations (write operations) executed from the frontend?**
> **Answer**:
> "Frontend components invoke async backend functions exported from Convex using `convex.mutation(api.reservations.createReservation, { ...args })`. 
> 
> Inside Convex backend files (e.g. [convex/reservations.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/reservations.ts)), the function is declared via `mutation({ args: {...}, handler: async (ctx, args) => {...} })`. The handler runs within an isolated ACID-compliant transaction context (`ctx.db.insert`, `ctx.db.patch`), updating the Convex database and notifying all WebSocket listeners."

---

### **Q5: How does the AI Assistant (RAG) backend work?**
> **Answer**:
> "The AI Chat is exposed via `src/routes/(app)/ai-assistant/+page.svelte` and handled in [convex/rag.ts](file:///home/jaary5/Documents/mine/study/9th-(262)/web/project/MediVault/convex/rag.ts). It uses a **Retrieval-Augmented Generation (RAG)** pipeline where user queries are vectorized, matched against vector embeddings of medical documentation stored in Convex's vector search index, and fed alongside system prompts to an LLM context."
