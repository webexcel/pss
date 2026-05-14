/**
 * Payment Handler - Razorpay Integration
 */

(function() {
    'use strict';

    const config = window.paymentConfig || {};

    // Get all pay buttons
    const payButtons = document.querySelectorAll('.btn-pay');

    payButtons.forEach(button => {
        button.addEventListener('click', handlePayClick);
    });

    async function handlePayClick(e) {
        const button = e.currentTarget;
        const paymentType = button.dataset.type;

        if (!paymentType) {
            showError('Invalid payment option');
            return;
        }

        // Disable button and show loading
        setButtonLoading(button, true);

        try {
            // Create order
            const orderData = await createOrder(paymentType);

            if (!orderData.success) {
                throw new Error(orderData.error || 'Failed to create order');
            }

            // Open Razorpay checkout
            openRazorpayCheckout(orderData, button);

        } catch (error) {
            console.error('Payment error:', error);
            showError(error.message || 'Something went wrong. Please try again.');
            setButtonLoading(button, false);
        }
    }

    async function createOrder(paymentType) {
        const response = await fetch('create-order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                payment_type: paymentType,
                csrf_token: config.csrfToken
            })
        });

        if (!response.ok) {
            const error = await response.json();
            throw new Error(error.error || 'Server error');
        }

        return response.json();
    }

    function openRazorpayCheckout(orderData, button) {
        const options = {
            key: config.razorpayKey,
            amount: orderData.amount,
            currency: orderData.currency,
            name: config.schoolName,
            description: 'Integrated Course Fee Payment',
            order_id: orderData.order_id,
            prefill: {
                name: config.studentName,
                contact: config.contact,
                email: config.email || ''
            },
            theme: {
                color: '#2563eb'
            },
            handler: function(response) {
                handlePaymentSuccess(response);
            },
            modal: {
                ondismiss: function() {
                    setButtonLoading(button, false);
                }
            }
        };

        const rzp = new Razorpay(options);

        rzp.on('payment.failed', function(response) {
            handlePaymentFailure(response);
            setButtonLoading(button, false);
        });

        rzp.open();
    }

    function handlePaymentSuccess(response) {
        // Create form and submit to verify-payment.php
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'verify-payment.php';

        const fields = {
            razorpay_order_id: response.razorpay_order_id,
            razorpay_payment_id: response.razorpay_payment_id,
            razorpay_signature: response.razorpay_signature
        };

        for (const [name, value] of Object.entries(fields)) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            form.appendChild(input);
        }

        document.body.appendChild(form);
        form.submit();
    }

    function handlePaymentFailure(response) {
        console.error('Payment failed:', response.error);

        const errorMsg = response.error.description ||
                        response.error.reason ||
                        'Payment failed';

        // Redirect to failure page with error
        window.location.href = 'failure.php?error=cancelled';
    }

    function setButtonLoading(button, loading) {
        if (loading) {
            button.classList.add('loading');
            button.disabled = true;
        } else {
            button.classList.remove('loading');
            button.disabled = false;
        }
    }

    function showError(message) {
        // Create error alert
        const existingAlert = document.querySelector('.alert-error.js-alert');
        if (existingAlert) {
            existingAlert.remove();
        }

        const alert = document.createElement('div');
        alert.className = 'alert alert-error js-alert';
        alert.textContent = message;

        const cardBody = document.querySelector('.card-body');
        if (cardBody) {
            cardBody.insertBefore(alert, cardBody.firstChild);

            // Auto remove after 5 seconds
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }
    }

})();
