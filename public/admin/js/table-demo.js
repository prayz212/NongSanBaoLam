window.addEventListener('DOMContentLoaded', event => {
  const datatablesSimple = document.getElementById('billTables');
  if (datatablesSimple) {
      new simpleDatatables.DataTable(datatablesSimple);
  }

  const productTables = document.getElementById('productTables');
  if (productTables) {
      new simpleDatatables.DataTable(productTables);
  }

  const accountTables = document.getElementById("accountTables");
  if (accountTables) {
      new simpleDatatables.DataTable(accountTables);
  }
});