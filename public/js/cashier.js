document.addEventListener('DOMContentLoaded', () => {
    const discount = document.getElementById('discountInput');
    const amount = document.getElementById('amountPaid');
    const totalElement = document.getElementById('grandTotal');
    const changeElement = document.getElementById('changeAmount');

    if (discount && amount && totalElement && changeElement) {
        const baseTotal = Number(document.body.dataset.baseTotal || 0);

        // Read the total shown by Laravel if no data attribute is supplied.
        let subtotalText = document.querySelector('.checkout-card .total-row strong')?.textContent || '0';
        let subtotal = Number(subtotalText.replace(/[^\d.-]/g, '')) || 0;

        const updateMoney = () => {
            const discountValue = Math.max(0, Number(discount.value) || 0);
            const total = Math.max(0, subtotal - discountValue);
            const paid = Math.max(0, Number(amount.value) || 0);
            const change = Math.max(0, paid - total);

            totalElement.textContent = `${Math.round(total).toLocaleString()} FCFA`;
            changeElement.textContent = `${Math.round(change).toLocaleString()} FCFA`;
            changeElement.classList.toggle('positive', paid >= total);
            changeElement.classList.toggle('negative', paid < total);
        };

        discount.addEventListener('input', updateMoney);
        amount.addEventListener('input', updateMoney);
        updateMoney();
    }

    document.querySelectorAll('.pay-method').forEach(method => {
        const input = method.querySelector('input[type="radio"]');
        if (!input) return;

        input.addEventListener('change', () => {
            document.querySelectorAll('.pay-method').forEach(x => x.classList.remove('active'));
            method.classList.add('active');
        });
    });

    document.querySelectorAll('[data-confirm]').forEach(button => {
        button.addEventListener('click', event => {
            if (!window.confirm(button.dataset.confirm)) {
                event.preventDefault();
            }
        });
    });

    // Prevent accidental double checkout.
    const checkoutForm = document.getElementById('checkoutForm');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', () => {
            const button = checkoutForm.querySelector('.checkout-btn');
            if (button) {
                button.disabled = true;
                button.textContent = 'Processing...';
            }
        });
    }
});
