const quantityInputs = document.querySelectorAll('.cantidad-producto');
const totalElement = document.querySelector('[data-compra-total]');

function updatePurchaseTotal() {
    if (!totalElement) {
        return;
    }

    const total = [...quantityInputs].reduce((sum, input) => {
        const quantity = Number.parseInt(input.value, 10);
        const price = Number.parseFloat(input.dataset.precio);
        return sum + (Number.isInteger(quantity) && quantity > 0 ? quantity * price : 0);
    }, 0);

    totalElement.textContent = total.toLocaleString('es-MX', {
        style: 'currency',
        currency: 'MXN'
    });
}

quantityInputs.forEach((input) => input.addEventListener('input', updatePurchaseTotal));
updatePurchaseTotal();
