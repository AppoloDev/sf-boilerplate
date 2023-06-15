class Toast extends HTMLElement {
    connectedCallback() {
        setTimeout(() => {
            this.remove();
        }, this.getAttribute('duration') ?? 5000)
    }
}

window.customElements.define('dismiss-toast', Toast);



