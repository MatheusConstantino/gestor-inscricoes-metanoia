# Gestor de Grupo de Oração

A robust, scalable, and white-label management system for prayer groups, built on Laravel 12. This project is engineered with a focus on clean architecture, maintainability, and a professional user experience, serving as a blueprint for high-quality application development.

---

## 🏛️ Architectural Philosophy

This project is not just about features; it's about building them the *right way*. Our philosophy is grounded in creating a system that is a pleasure to develop, maintain, and scale.

-   **Clean & Decoupled:** We enforce a strict separation of concerns. Controllers are thin, business logic is encapsulated in Services, and data access is abstracted by Repositories.
-   **Convention over Configuration:** We leverage Laravel's power by following its conventions, but we are not afraid to establish our own patterns where they bring clarity and consistency.
-   **Developer Experience (DX) First:** A happy developer is a productive developer. We prioritize clear documentation, consistent patterns, and a streamlined local development setup.

---

## 🚀 Key Architectural Decisions & Tradeoffs

Every architectural choice has consequences. This section documents our key decisions and why we made them, providing context for future development.

#### 1. **Service & Repository Pattern**
-   **Decision:** Isolate business logic in a `Service` layer and data access in a `Repository` layer.
-   **Why:** This keeps our `Controllers` lean and focused on handling HTTP requests. It makes our business logic reusable and, most importantly, highly testable in isolation from the web layer.
-   **Tradeoff:** This introduces a bit more boilerplate compared to placing logic directly in controllers or models. However, we believe this is a small price to pay for the immense gains in testability, maintainability, and clarity as the application grows.

#### 2. **Dedicated Pages for CRUD Forms (Not Modals)**
-   **Decision:** All `create` and `edit` actions are handled on dedicated, full-screen pages rather than in modals.
-   **Why:** While modals are suitable for very simple actions, they scale poorly. Dedicated pages provide a focused user experience, are easier to manage for complex forms, and offer the benefits of unique URLs (bookmarking, sharing). This establishes a single, consistent pattern for all data entry.
-   **Tradeoff:** This approach involves more page loads compared to a full SPA (Single Page Application). We've mitigated this by keeping the list views highly dynamic with AJAX for actions like `delete` and `status-toggle`, achieving a hybrid model that balances performance and scalability.

#### 3. **Shared Form Partials (`_form.blade.php`)**
-   **Decision:** Form fields for `create` and `edit` views are extracted into a shared Blade partial.
-   **Why:** This adheres to the DRY (Don't Repeat Yourself) principle. Any change to a form field only needs to be made in one place, reducing the chance of errors and making the codebase significantly more maintainable.
-   **Tradeoff:** A minor increase in cognitive load, as the developer needs to look at both the parent view and the partial. This is a negligible tradeoff for the benefits of maintainability.

#### 4. **Hybrid Frontend: Blade with AJAX Sprinkles**
-   **Decision:** We use server-rendered Blade views for our primary structure, enhanced with jQuery/AJAX for dynamic actions on the list pages (delete, status toggle) and for form submissions.
-   **Why:** This gives us the rapid development speed and SEO benefits of a traditional server-rendered application, while still providing a modern, responsive user experience where it matters most. It avoids the complexity of a full frontend framework like Vue or React, which is overkill for this project's needs.
-   **Tradeoff:** We don't have a fully "single-page" feel. However, our chosen workflow (AJAX form submit -> toast -> redirect) is fast, reliable, and intuitive for the user.

---

## 💻 Development Patterns

To ensure consistency, all new features should adhere to the following established patterns. The **Organizations CRUD** serves as the canonical implementation.

#### **Backend CRUD Flow**
1.  **Controller:** Receives the `Request`. For `store` and `update`, it uses a Form Request for validation.
2.  **Service:** The controller calls the appropriate method in the `Service` layer, passing the validated data.
3.  **Repository:** The `Service` calls the `Repository` to perform the database operation (`create`, `update`, `delete`).
4.  **Response:**
    -   For standard `POST` requests (`store`, `update`), the controller redirects back to the `index` route with a flashed success message: `return redirect()->route('...')->with('success', 'Message');`
    -   For `AJAX` requests (`delete`, `toggle-status`), the controller returns a JSON response: `return response()->json(['success' => true, 'message' => '...']);`

#### **Frontend CRUD Flow**
1.  **List Page (`index.blade.php`):**
    -   Displays a list of records.
    -   Contains links to the `create` and `edit` pages.
    -   Handles `delete` and `status-toggle` actions via AJAX, displaying a toast on success and refreshing the list.
    -   Includes a script to check for a flashed session message (`@if(session('success'))`) and display it as a toast on page load.
2.  **Form Pages (`create.blade.php`, `edit.blade.php`):**
    -   Use the shared `_form.blade.php` partial.
    -   Submit via a standard, full-page `POST` request.

---

## 🛠️ Getting Started (Development Environment)

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/MatheusConstantino/gestor-inscricoes-metanoia.git
    cd gestor-incricoes-app
    ```

2.  **Install dependencies:**
    ```bash
    composer install
    npm install
    ```

3.  **Configure the environment:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Configure the database** in your `.env` file and run the migrations:
    ```bash
    php artisan migrate
    ```

5.  **Build frontend assets:**
    ```bash
    npm run dev
    ```

6.  **Start the development server:**
    ```bash
    php artisan serve
