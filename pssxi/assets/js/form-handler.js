/**
 * Form Handler - Multi-step Admission Form
 *
 * Handles AJAX form submissions, validation, and navigation
 */

(function () {
    'use strict';

    // Configuration
    const config = window.APP_CONFIG || {
        apiUrl: '/pssxi/api',
        sessionToken: '',
        currentStep: 1
    };

    // State
    let isSubmitting = false;
    let sessionToken = config.sessionToken;

    /**
     * Initialize the form handler
     */
    function init() {
        // Try to get token from sessionStorage if not in config
        if (!sessionToken) {
            sessionToken = sessionStorage.getItem('app_token');
        }

        // Start new application if no session token
        if (!sessionToken && config.currentStep === 1) {
            startApplication();
        }

        // Bind form events
        bindFormEvents();

        // Bind draft save button
        bindDraftButton();

        // Bind reset button (step 3)
        bindResetButton();
    }

    /**
     * Start a new application
     */
    async function startApplication() {
        try {
            const response = await apiRequest('POST', 'application/start');

            if (response.success) {
                sessionToken = response.data.token;

                // Store in session storage for page navigation
                sessionStorage.setItem('app_token', sessionToken);
                sessionStorage.setItem('application_id', response.data.application_id);

                // Update draft status
                updateDraftStatus('New Application');

                // Sync token to PHP session
                await submitSessionToken(sessionToken, response.data.application_id);
            }
        } catch (error) {
            console.error('Failed to start application:', error);
            showToast('Failed to start application. Please refresh the page.', 'error');
        }
    }

    /**
     * Submit session token to PHP session
     */
    async function submitSessionToken(token, applicationId) {
        try {
            const response = await fetch('session.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    app_token: token,
                    application_id: applicationId
                })
            });

            const data = await response.json();
            return data.success;
        } catch (error) {
            console.error('Failed to sync session:', error);
            return false;
        }
    }

    /**
     * Sync step data to PHP session
     */
    async function syncSessionData(step, formData) {
        try {
            const payload = {
                app_token: sessionToken,
                application_id: sessionStorage.getItem('application_id')
            };

            // Add step-specific data
            payload[`step${step}_data`] = formData;

            const response = await fetch('session.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();
            return data.success;
        } catch (error) {
            console.error('Failed to sync step data:', error);
            return false;
        }
    }

    /**
     * Bind form submission events
     */
    function bindFormEvents() {
        const step1Form = document.getElementById('step1-form');
        const step2Form = document.getElementById('step2-form');
        const step3Form = document.getElementById('step3-form');

        if (step1Form) {
            step1Form.addEventListener('submit', (e) => handleFormSubmit(e, 1));
        }

        if (step2Form) {
            step2Form.addEventListener('submit', (e) => handleFormSubmit(e, 2));
        }

        if (step3Form) {
            step3Form.addEventListener('submit', (e) => handleFormSubmit(e, 3));
        }
    }

    /**
     * Handle form submission
     */
    async function handleFormSubmit(event, step) {
        event.preventDefault();

        if (isSubmitting) return;

        const form = event.target;
        const submitBtn = form.querySelector('[type="submit"]') || document.getElementById('next-step-btn') || document.getElementById('submit-btn');

        // Clear previous errors
        clearErrors();

        // Get form data
        const formData = getFormData(form, step);

        // Validate required fields
        if (!validateForm(form, step)) {
            return;
        }

        // Get session token from storage if not available
        if (!sessionToken) {
            sessionToken = sessionStorage.getItem('app_token');
        }

        if (!sessionToken) {
            showToast('Session expired. Please start a new application.', 'error');
            window.location.href = 'step1.php';
            return;
        }

        // Show loading state
        setLoading(submitBtn, true);
        isSubmitting = true;

        try {
            let endpoint = '';
            let data = formData;

            if (step === 1) {
                endpoint = `application/${sessionToken}/step1`;
            } else if (step === 2) {
                endpoint = `application/${sessionToken}/step2`;
            } else if (step === 3) {
                endpoint = `application/${sessionToken}/submit`;
            }

            const response = await apiRequest('POST', endpoint, data);

            if (response.success) {
                // Store form data in session storage for review page
                sessionStorage.setItem(`step${step}_data`, JSON.stringify(formData));

                if (step === 1) {
                    // Sync step1 data to PHP session before navigating
                    await syncSessionData(step, formData);
                    showToast('Personal information saved!', 'success');
                    window.location.href = 'step2.php';
                } else if (step === 2) {
                    // Sync step2 data to PHP session before navigating
                    await syncSessionData(step, formData);
                    showToast('Parent details saved!', 'success');
                    window.location.href = 'step3.php';
                } else if (step === 3) {
                    showToast('Application submitted successfully!', 'success');
                    // Clear all session data
                    sessionStorage.clear();
                    // Redirect to success page
                    window.location.href = 'success.php?id=' + encodeURIComponent(response.data.application_id);
                }
            } else {
                // Show validation errors
                if (response.errors && Object.keys(response.errors).length > 0) {
                    Object.entries(response.errors).forEach(([field, message]) => {
                        showError(field, message);
                    });
                    showToast('Please fix the errors and try again.', 'error');
                } else {
                    showToast(response.message || 'An error occurred.', 'error');
                }

            }
        } catch (error) {
            console.error('Form submission error:', error);
            showToast('Network error. Please try again.', 'error');
        } finally {
            setLoading(submitBtn, false);
            isSubmitting = false;
        }
    }

    /**
     * Get form data as object
     */
    function getFormData(form, step) {
        const formData = new FormData(form);
        const data = {};

        if (step === 2) {
            // Handle nested parent data
            data.father = {};
            data.mother = {};
            data.guardian = {};
            data.guardian_enabled = formData.get('guardian_enabled') === '1';

            for (const [key, value] of formData.entries()) {
                if (key.startsWith('father[')) {
                    const field = key.match(/\[([^\]]+)\]/)[1];
                    data.father[field] = value;
                } else if (key.startsWith('mother[')) {
                    const field = key.match(/\[([^\]]+)\]/)[1];
                    data.mother[field] = value;
                } else if (key.startsWith('guardian[')) {
                    const field = key.match(/\[([^\]]+)\]/)[1];
                    data.guardian[field] = value;
                }
            }
        } else if (step === 3) {
            data.is_existing_student = formData.get('is_existing_student') === '1';
            data.terms_accepted = formData.get('terms_accepted') === '1';
        } else {
            for (const [key, value] of formData.entries()) {
                data[key] = value;
            }
        }

        return data;
    }

    /**
     * Validate form
     */
    function validateForm(form, step) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                const label = field.closest('label')?.querySelector('span')?.textContent || field.name;
                showError(field.name.replace(/\[|\]/g, '_'), `${label.replace(' *', '')} is required`);
                isValid = false;
            }
        });

        // Step 3: Check terms accepted
        if (step === 3) {
            const terms = form.querySelector('[name="terms_accepted"]');
            if (terms && !terms.checked) {
                showError('terms_accepted', 'You must accept the terms and declaration');
                isValid = false;
            }
        }

        return isValid;
    }

    /**
     * Bind draft save button
     */
    function bindDraftButton() {
        const draftBtn = document.getElementById('save-draft-btn');
        if (!draftBtn) return;

        draftBtn.addEventListener('click', async () => {
            if (isSubmitting) return;

            const form = document.querySelector('form');
            if (!form) return;

            const step = config.currentStep;
            const formData = getFormData(form, step);

            if (!sessionToken) {
                sessionToken = sessionStorage.getItem('app_token');
            }

            if (!sessionToken) {
                showToast('Please fill in some details first.', 'warning');
                return;
            }

            setLoading(draftBtn, true);
            isSubmitting = true;

            try {
                const response = await apiRequest('POST', `application/${sessionToken}/draft`, {
                    step: step,
                    form_data: formData
                });

                if (response.success) {
                    updateDraftStatus('Draft Saved');
                    showToast('Draft saved successfully!', 'success');
                } else {
                    showToast(response.message || 'Failed to save draft.', 'error');
                }
            } catch (error) {
                console.error('Draft save error:', error);
                showToast('Failed to save draft.', 'error');
            } finally {
                setLoading(draftBtn, false);
                isSubmitting = false;
            }
        });
    }

    /**
     * Bind reset button
     */
    function bindResetButton() {
        const resetBtn = document.getElementById('reset-form-btn');
        if (!resetBtn) return;

        resetBtn.addEventListener('click', async () => {
            if (!confirm('Are you sure you want to reset the form? All data will be lost.')) {
                return;
            }

            if (!sessionToken) {
                sessionToken = sessionStorage.getItem('app_token');
            }

            if (!sessionToken) {
                window.location.href = 'step1.php';
                return;
            }

            try {
                const response = await apiRequest('POST', `application/${sessionToken}/reset`);

                if (response.success) {
                    sessionStorage.clear();
                    showToast('Form reset successfully.', 'success');
                    window.location.href = 'step1.php';
                } else {
                    showToast(response.message || 'Failed to reset form.', 'error');
                }
            } catch (error) {
                console.error('Reset error:', error);
                showToast('Failed to reset form.', 'error');
            }
        });
    }

    /**
     * API request helper
     */
    async function apiRequest(method, endpoint, data = null) {
        const url = config.apiUrl + '/' + endpoint;

        const options = {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        };

        if (data && method !== 'GET') {
            options.body = JSON.stringify(data);
        }

        const response = await fetch(url, options);
        return response.json();
    }

    /**
     * Show error for a field
     */
    function showError(field, message) {
        const errorEl = document.querySelector(`[data-field="${field}"]`);
        if (errorEl) {
            errorEl.textContent = message;
            errorEl.classList.remove('hidden');
        }

        // Also highlight the input
        const input = document.querySelector(`[name="${field}"]`) ||
            document.querySelector(`[name="${field.replace('_', '[')}]"]`) ||
            document.getElementById(field);

        if (input) {
            input.classList.add('border-red-500');
            input.addEventListener('input', () => {
                input.classList.remove('border-red-500');
                if (errorEl) errorEl.classList.add('hidden');
            }, { once: true });
        }
    }

    /**
     * Clear all errors
     */
    function clearErrors() {
        document.querySelectorAll('.error-message').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });

        document.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500');
        });
    }

    /**
     * Set loading state on button
     */
    function setLoading(button, loading) {
        if (!button) return;

        if (loading) {
            button.disabled = true;
            button.dataset.originalText = button.innerHTML;
            button.innerHTML = '<span class="spinner"></span> Processing...';
        } else {
            button.disabled = false;
            button.innerHTML = button.dataset.originalText || button.innerHTML;
        }
    }

    /**
     * Update draft status indicator
     */
    function updateDraftStatus(status) {
        const statusEl = document.getElementById('draft-status');
        if (!statusEl) return;

        statusEl.innerHTML = `
            <span class="w-2 h-2 rounded-full bg-blue-500 mr-1"></span>
            ${status}
        `;
        statusEl.classList.remove('bg-slate-100', 'text-slate-500');
        statusEl.classList.add('bg-blue-100', 'text-blue-700');
    }

    /**
     * Show toast notification
     */
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container') || createToastContainer();

        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.textContent = message;

        container.appendChild(toast);

        // Trigger animation
        setTimeout(() => toast.classList.add('show'), 10);

        // Remove after delay
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    /**
     * Create toast container if not exists
     */
    function createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.style.cssText = 'position: fixed; bottom: 20px; right: 20px; z-index: 9999;';
        document.body.appendChild(container);
        return container;
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Restore session token from storage on page load
    if (!sessionToken) {
        sessionToken = sessionStorage.getItem('app_token');
    }

})();
