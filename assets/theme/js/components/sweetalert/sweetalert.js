import Swal from 'sweetalert2/src/sweetalert2';
import './_sweetalert.scss';

class SweetAlert extends HTMLElement {
	connectedCallback() {
		this.confirmationLink = this.querySelector('a');
		this.confirmationLink.addEventListener('click', (e) => {
			e.preventDefault();
			this.displaySwal();
		});
	}

	async displaySwal() {
		Swal.fire({
			title: this.getAttribute('title'),
			text: this.getAttribute('text'),
			showCancelButton: true,
			cancelButtonText: 'Annuler',
			confirmButtonText: 'Je confirme',
			customClass: {
				container: `sweetalert sweetalert__container sweetalert__container__${this.getAttribute('type')}`,
				popup: 'sweetalert__popup',
				title: `sweetalert__title text__${this.getAttribute('type')}`,
				htmlContainer: `sweetalert__content`,
				actions: `sweetalert__actions`,
				loader: 'hidden',
				confirmButton: `button button-${this.getAttribute('type')}`,
				cancelButton: 'button button-default',
			},
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = this.confirmationLink.href;
			}
		});
	}
}

window.customElements.define('sweet-alert', SweetAlert);
