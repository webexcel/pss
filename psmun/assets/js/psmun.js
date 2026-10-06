/**
 * Clarion PSMUN Registration - Form + Razorpay Checkout
 */

(function() {
    'use strict';

    const config = window.psmunConfig || {};
    const form = document.getElementById('psmun-form');
    if (!form) return;

    const studentType = form.dataset.type;
    const submitButton = form.querySelector('button[type="submit"]');

    // ---------- Group booking (other schools) ----------

    const delegateList = document.getElementById('delegate-list');
    const rowTemplate = document.getElementById('delegate-row-template');
    const addButton = document.getElementById('add-delegate');
    const maxDelegates = delegateList ? parseInt(delegateList.dataset.max, 10) : 1;

    function formatAmount(amount) {
        return '₹' + amount.toLocaleString('en-IN');
    }

    function addDelegateRow() {
        if (delegateList.children.length >= maxDelegates) return;
        const row = rowTemplate.content.firstElementChild.cloneNode(true);
        row.querySelector('.delegate-remove').addEventListener('click', function() {
            row.remove();
            refreshDelegates();
        });
        delegateList.appendChild(row);
        refreshDelegates();
        row.querySelector('.delegate-name').focus();
    }

    function refreshDelegates() {
        const rows = delegateList.querySelectorAll('.delegate-row');
        rows.forEach((row, i) => {
            row.querySelector('.delegate-no').textContent = (i + 1) + '.';
            // Always keep at least one delegate
            row.querySelector('.delegate-remove').style.visibility = rows.length > 1 ? 'visible' : 'hidden';
        });

        const total = rows.length * config.feePerDelegate;
        document.getElementById('delegate-count').textContent = rows.length;
        document.getElementById('total-amount').textContent = formatAmount(total);
        submitButton.textContent = 'Pay ' + formatAmount(total);
        addButton.disabled = rows.length >= maxDelegates;
        addButton.textContent = rows.length >= maxDelegates
            ? 'Maximum ' + maxDelegates + ' delegates per booking'
            : '+ Add Delegate';
    }

    if (delegateList) {
        addButton.addEventListener('click', addDelegateRow);
        addDelegateRow();
        form.querySelector('#school_name').focus();
    }

    // ---------- Submit + payment ----------

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        clearError();

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        setLoading(true);

        try {
            const orderData = await createOrder(collectFormData());
            openRazorpayCheckout(orderData);
        } catch (error) {
            showError(error.message || 'Something went wrong. Please try again.');
            setLoading(false);
        }
    });

    function collectFormData() {
        const data = { student_type: studentType, csrf_token: config.csrfToken };

        form.querySelectorAll('input[name]').forEach(input => {
            data[input.name] = input.value.trim();
        });

        if (delegateList) {
            data.delegates = Array.from(delegateList.querySelectorAll('.delegate-row')).map(row => ({
                name: row.querySelector('.delegate-name').value.trim(),
                class: row.querySelector('.delegate-class').value.trim()
            }));
        }

        return data;
    }

    async function createOrder(data) {
        const response = await fetch('create-order.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        let result;
        try {
            result = await response.json();
        } catch (err) {
            throw new Error('Server error. Please try again.');
        }

        if (!response.ok || !result.success) {
            throw new Error(result.error || 'Failed to create order');
        }

        return result;
    }

    function openRazorpayCheckout(orderData) {
        const rzp = new Razorpay({
            key: config.razorpayKey,
            amount: orderData.amount,
            currency: orderData.currency,
            name: config.eventName,
            description: orderData.description,
            order_id: orderData.order_id,
            prefill: orderData.prefill,
            theme: { color: '#122D57' },
            handler: handlePaymentSuccess,
            modal: {
                ondismiss: function() {
                    setLoading(false);
                }
            }
        });

        // Razorpay lets the user retry inside the popup, so just show the reason here
        rzp.on('payment.failed', function(response) {
            showError('Payment failed: ' + (response.error.description || 'please try again.'));
        });

        rzp.open();
    }

    function handlePaymentSuccess(response) {
        const verifyForm = document.createElement('form');
        verifyForm.method = 'POST';
        verifyForm.action = 'verify-payment.php';

        ['razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature'].forEach(name => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = response[name];
            verifyForm.appendChild(input);
        });

        document.body.appendChild(verifyForm);
        verifyForm.submit();
    }

    function setLoading(loading) {
        submitButton.classList.toggle('loading', loading);
        submitButton.disabled = loading;
    }

    function clearError() {
        const existing = document.querySelector('.alert-error.js-alert');
        if (existing) existing.remove();
    }

    function showError(message) {
        clearError();
        const alert = document.createElement('div');
        alert.className = 'alert alert-error js-alert';
        alert.textContent = message;
        form.parentNode.insertBefore(alert, form);
        alert.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

})();
