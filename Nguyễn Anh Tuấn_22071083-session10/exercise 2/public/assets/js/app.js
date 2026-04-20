document
  .getElementById("productForm")
  ?.addEventListener("submit", function (e) {
    const name = document.querySelector("input[name='productName']").value;

    if (!name.trim()) {
      alert("Product name is required!");
      e.preventDefault();
    }
  });
