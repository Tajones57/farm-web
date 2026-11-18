// Show / hide password
document.querySelectorAll('.toggle-pw').forEach(function (icon) {
  icon.addEventListener('click', function () {
    var pw = document.getElementById('pw');
    pw.type = pw.type === 'password' ? 'text' : 'password';
  });
});

// Product page quantity + live total
var detail = document.querySelector('.detail');
if (detail) {
  var price = parseFloat(detail.dataset.price);
  var qty = 1;
  var val = document.getElementById('qtyVal');
  var input = document.getElementById('qtyInput');
  var total = document.getElementById('totalPrice');
  function peso(n) { return '₱' + (Math.round(n * 100) / 100).toString(); }
  function update() {
    val.textContent = qty;
    input.value = qty;
    total.textContent = peso(price * qty);
  }
  document.getElementById('qtyPlus').addEventListener('click', function () { qty++; update(); });
  document.getElementById('qtyMinus').addEventListener('click', function () { if (qty > 1) { qty--; update(); } });
}
