# Database App — Name & Age Registration with MySQL

A simple app: a form (name + age) saves data to MySQL, displays it in a table,
lets you flip each user's status (0/1) with a **Toggle** button, and delete
entries with a **Delete** button — all without reloading the page (AJAX).

## Files

| File | Purpose |
|---|---|
| `database.sql` | Creates the `users` table |
| `config.php` | Database connection settings |
| `index.php` | Main page (form + table) |
| `toggle.php` | AJAX endpoint that flips a user's status in the database |
| `delete.php` | AJAX endpoint that deletes a user from the database |
| `style.css` | Styling (dark theme) |
| `script.js` | Toggle & Delete logic using fetch() — no page refresh |

## Running locally with XAMPP

1. Start **Apache** and **MySQL** in the XAMPP Control Panel.
2. Copy this whole folder into `C:\xampp\htdocs\student-db-app`.
3. Go to `http://localhost/phpmyadmin`, click **New**, name the database
   `studentdb`, click **Create**.
4. Click on `studentdb` → **SQL** tab → paste the contents of `database.sql` → **Go**.
5. Check `config.php` — the local XAMPP values (`localhost`, `root`, empty password,
   `studentdb`) should already be active.
6. Open `http://localhost/student-db-app/index.php` in your browser.

## Deploying to InfinityFree

1. Create an account at [infinityfree.net](https://infinityfree.net) and create a new website.
2. In the control panel, go to **MySQL Databases** and create a new database.
   You'll get a `Hostname`, `Database name`, `Username`, and `Password` — save these.
3. Open **phpMyAdmin** from the same panel, select your database, go to the
   **SQL** tab, paste the contents of `database.sql`, and click **Go**.
4. In `config.php`, comment out the local XAMPP block and uncomment/fill in the
   InfinityFree block with the values from step 2.
5. Upload all files (`index.php`, `toggle.php`, `delete.php`, `config.php`,
   `style.css`, `script.js`) into the `htdocs` folder using the Online File
   Manager or FTP (e.g. FileZilla).
6. Visit your site (e.g. `http://yoursite.infinityfreeapp.com`) and test the form,
   Toggle, and Delete buttons.

## How it works

1. The **form** in `index.php` submits via POST to the same page.
2. PHP receives `name` and `age`, uses a **prepared statement**
   (`INSERT ... VALUES (?, ?, 0)`) to protect against SQL injection, and saves
   them to the `users` table with an initial status of 0.
3. After saving, `header("Location: index.php")` reloads the page and prevents
   duplicate submissions on refresh. The page then fetches all rows from the
   database and displays them in the table.
4. Each row has a **Toggle** button and a **Delete** button, both carrying a
   `data-id` attribute with that user's ID.
5. Clicking **Toggle** sends a `fetch()` (AJAX) request to `toggle.php`, which
   flips the status (0↔1) in the database and returns the new value as JSON.
   `script.js` updates that row's badge instantly — no page reload.
6. Clicking **Delete** asks for confirmation, then sends a `fetch()` request to
   `delete.php`, which removes the row from the database and returns a JSON
   result. `script.js` removes the row from the table instantly — no page reload.
