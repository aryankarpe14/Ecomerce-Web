document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.querySelector('input[name="search"]');
  const products = document.querySelectorAll('.product');
  searchInput.addEventListener('input', function () {
    const query = this.value.toLowerCase();
    products.forEach(product => {
      const text = product.querySelector('figcaption').textContent.toLowerCase();
      if (text.includes(query)) {
        product.style.display = 'block';
      } else {
        product.style.display = 'none';
      }
    });
  });
});