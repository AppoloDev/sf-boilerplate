import TomSelect from "tom-select";
import "./_tomselect.scss"

class Autocomplete extends HTMLSelectElement {
    connectedCallback() {
        if (this.hasAttribute('is')) {
            this.removeAttribute('is');

            let options = {
                plugins: this.dataset.plugins ? JSON.parse(this.dataset.plugins) : [],
                maxOptions: null,
                create: this.dataset.create,
                render: {
                    no_results: function (data, escape) {
                        return '<div class="no-results">Aucun résultat trouvé</div>';
                    },
                }
            };

            if (this.hasAttribute('multiple')) {
                options.plugins.push('remove_button');
            }

            TomSelect.define('maxItemPlugin', this.maxItemPlugin)
            TomSelect.define('splitLabelPlugin', this.splitLabelPlugin)
            new TomSelect(this, options);
        }
    }

    maxItemPlugin() {
        const self = this;
        let span;

        const itemCount = function () {
            hideItems(self.items);

            if (self.items.length > 2) {
                const numberHiddenItem = self.items.length - 2;
                span.className = 'items-count';
                span.innerText = `+${numberHiddenItem} élément${numberHiddenItem > 1 ? 's' : ''}`
            } else {
                span.className = 'hidden';
            }
        }

        const hideItems = function (items) {
            items.forEach((id) => {
                self.control.querySelector(`[data-value="${id}"]`).classList.remove('!hidden');
            })

            const cloneItems = [...items];

            cloneItems.splice(0, 2);
            cloneItems.forEach((id) => {
                self.control.querySelector(`[data-value="${id}"]`).classList.add('!hidden');
            })
        }

        self.on('initialize', () => {
            span = document.createElement('span');
            self.control.insertBefore(span, self.control_input);

            itemCount()
        });

        self.on('item_remove', itemCount);

        self.on('item_add', itemCount);
    }

    splitLabelPlugin() {
        const self = this;
        self.on('initialize', () => {
            self.settings.render.item = function(data, escape) {
                const text = escape(data.text);
                const project = text.split('#').pop();
                return '<div>' + project + '</div>';
            }
            self.settings.render.option = function(data, escape) {
                const text = escape(data.text);
                const project = text.split('#').pop();
                return '<div>' + project + '</div>';
            }

            self.sync();
        });
    }

    disconnectedCallback() {
    }
}

window.customElements.define('tom-select', Autocomplete, {extends: 'select'});
// TODO: Replace to htmlElement + refactor pour passer des options depuis attributes