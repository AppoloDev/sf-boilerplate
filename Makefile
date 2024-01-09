.PHONY: lint
lint:
	vendor/bin/phpstan analyse src
.PHONY: fix
fix:
	vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php --diff
.PHONY: clear
clear:
	php bin/console c:c
.PHONY: schema
schema:
	php bin/console d:s:u -f
.PHONY: create-user
create-user:
	php bin/console user:create
.PHONY: maizzle-dev
maizzle-dev:
	cd ./maizzle && pnpm dev
.PHONY: maizzle-build
maizzle-build:
	cd ./maizzle && pnpm build
ngrok:
	ngrok http https://localhost:8000
