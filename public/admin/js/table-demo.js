window.addEventListener('DOMContentLoaded', event => {
  const datatablesSimple = document.getElementById('billTables');
  if (datatablesSimple) {
      new simpleDatatables.DataTable(datatablesSimple);
  }

  const productTables = document.getElementById('productTables');
  if (productTables) {
      new simpleDatatables.DataTable(productTables);
  }

  // const warehouseTables = document.getElementById("warehouseDatatables");
  // if (warehouseTables) {
  //     new simpleDatatables.DataTable(warehouseTables);
  // }
});