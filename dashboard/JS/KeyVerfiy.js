class KeyVerification {
    constructor() {
        this.init();
    }

    init() {
        if (!window.notification) {
            window.notification = new Notification();
        }

        this.bindEvents();
        this.initDateTime();
    }

    bindEvents() {
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.submitForm(form);
            });
        }
    }

    async submitForm(form) {
        const keyInput = form.querySelector('input[name="key"]');
        if (!keyInput || !keyInput.value.trim()) {
            window.notification.showError('Please enter a key');
            return;
        }

        try {
            const formData = new FormData(form);
            const response = await fetch(window.location.href, {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.text();
            document.documentElement.innerHTML = result;
            this.initDateTime();
            this.bindEvents();

            // Show success notification if verification was successful
            const successResult = document.querySelector('.bg-green-800');
            if (successResult) {
                window.notification.showSuccess();
            }

        } catch (error) {
            window.notification.showError('An error occurred while verifying the key');
            console.error('Error:', error);
        }
    }

    initDateTime() {
        document.querySelectorAll('.datetime').forEach(element => {
            const timestamp = element.textContent;
            if (timestamp && !isNaN(timestamp)) {
                const date = new Date(timestamp * 1000);
                element.textContent = date.toLocaleString();
            }
        });
    }
}

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', () => {
    new KeyVerification();
});