class Notification {
    constructor() {
        this.init();
    }

    init() {
        this.progressBar = document.createElement('div');
        this.progressBar.className = 'progress-bar';
        document.body.appendChild(this.progressBar);

        this.overlay = document.createElement('div');
        this.overlay.className = 'overlay';
        document.body.appendChild(this.overlay);

        this.alert = document.createElement('div');
        this.alert.className = 'ios-alert';
        this.alert.innerHTML = `
            <div class="ios-alert-title">Error</div>
            <div class="ios-alert-message"></div>
            <div class="ios-alert-button">OK</div>
        `;
        document.body.appendChild(this.alert);

        this.alert.querySelector('.ios-alert-button').addEventListener('click', () => {
            this.hideError();
        });

        this.overlay.addEventListener('click', () => {
            this.hideError();
        });
    }

    showSuccess() {
        this.progressBar.classList.add('active');
        setTimeout(() => {
            this.progressBar.classList.remove('active');
        }, 2000);
    }

    showError(message) {
        this.alert.querySelector('.ios-alert-message').textContent = message;
        this.overlay.classList.add('show');
        this.alert.classList.add('show');
    }

    hideError() {
        this.overlay.classList.remove('show');
        this.alert.classList.remove('show');
    }
}

window.notification = new Notification();