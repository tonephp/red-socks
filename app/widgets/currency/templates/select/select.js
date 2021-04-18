const select = document.getElementById('js-currency-select');

if (select) {
  select.addEventListener('change', (event) => {
    window.location = `/currency/change?currency=${event.target.value}`;
  });
}