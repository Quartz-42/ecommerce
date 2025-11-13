.PHONY: php-stan
php-stan: 
	vendor/bin/phpstan analyse src templates

.PHONY: php-cs
php-cs:
	php-cs-fixer fix
 
.PHONY : tailwind-build
tailwind-build:
	symfony console tailwind:build --watch

.PHONY : generate-db
generate-db:
	symfony console doctrine:database:create --if-not-exists
	symfony console doctrine:schema:create
	symfony console doctrine:fixtures:load
