// main.js — JavaScript in the browser. Two behaviours, each answering
// an event, each guarded so pages without its elements skip it quietly
// (no console errors on any page). This file is linked from every page
// by includes/footer.php.

// Behaviour 1 — check the booking form as it is submitted (Lab 3's idea):
// stop the submit, point at the wrong field, say why. The server checks
// the same fields again in process-book.php; these checks are the polite
// first pass, not the protection.
const bookForm = document.querySelector('#book-form');
const formMessage = document.querySelector('#form-message');

if (bookForm) {
  bookForm.addEventListener('submit', function (event) {
    const name = document.querySelector('#fullname');
    const phone = document.querySelector('#phone');

    if (name.value.trim() === '') {
      event.preventDefault();
      formMessage.textContent = 'Please enter your full name.';
      name.focus();
      return;
    }

    if (phone.value.trim().length < 9) {
      event.preventDefault();
      formMessage.textContent = 'Please enter a valid phone number.';
      phone.focus();
      return;
    }

    formMessage.textContent = '';
  });
}

// Behaviour 2 — filter the bookings list as you type: every keystroke in
// the filter box hides the table rows that do not contain the text.
// (The Search form above the table is the other way in: it asks the
// database again, on the server.)
const filterBox = document.querySelector('#booking-filter');
const bookingsTable = document.querySelector('#bookings-table');

if (filterBox && bookingsTable) {
  filterBox.addEventListener('input', function () {
    const text = filterBox.value.trim().toLowerCase();
    bookingsTable.querySelectorAll('tbody tr').forEach(function (row) {
      row.hidden = !row.textContent.toLowerCase().includes(text);
    });
  });
}
