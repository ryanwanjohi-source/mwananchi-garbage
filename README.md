# Mwananchi Garbage — Group B (DBT 1305)

The team's Week 7 site, finished for the Week 13 team project. The pages
are PHP, bookings are saved in a MySQL database the team designed, and
the Bookings page can view, search, add, edit and delete them.
JavaScript checks the booking form in the browser and filters the
bookings list as you type.

## How to run it

1. Install XAMPP, then start Apache and MySQL in the XAMPP control panel.
2. Copy this folder into `C:\xampp\htdocs\mwananchi-garbage`.
3. Open http://localhost/phpmyadmin, click **Import**, and import
   `database/schema.sql` — it creates the database and the two tables.
4. Import `database/seed.sql` the same way — it adds the nine areas and
   twelve sample bookings, so the Bookings list has rows straight away.
5. Open http://localhost/mwananchi-garbage/ in the browser. Book a
   collection on the Book page, then open **Bookings** to see it,
   search it, edit it and delete it.

The database settings are in `config/config.php` — the XAMPP defaults
(localhost, user `root`, no password, database `mwananchi_garbage`).

## How it is put together

- Every page is a `.php` page sharing `includes/header.php` and
  `includes/footer.php`; the one database connection is written once,
  in `includes/db.php` (PDO, settings from `config/config.php`).
- The database has two tables: `areas` (the collection areas, held
  once) and `bookings` (one row per booking), joined by the foreign
  key `bookings.area_id → areas.id`.
- Bookings CRUD: `book.php` + `process-book.php` add a booking,
  `bookings.php` lists and searches them, `edit.php` +
  `process-edit.php` change one, `process-delete.php` removes one.
  Every query is a prepared statement, and every field is checked
  again on the server — a failed check shows its message beside the
  field on the form.
- `js/main.js` is linked from every page and does two things: it checks
  the booking form when it is submitted, and it filters the bookings
  list as you type.
- One stylesheet: `css/style.css`.

## Who built what

- **Ryan Wachira** — GitHub `ryanwanjohi-source` — the bookings
  feature: `book.php`, `bookings.php`, `edit.php`, `process-book.php`,
  `process-edit.php`, `process-delete.php`, and the database in
  `database/`.
- **[Teammate name]** — GitHub `[username]` — [the pages / feature
  they own]. *(Each member of Group B adds their own line here, with
  the feature they will show and explain at the check.)*
