.PHONY: php-stan
php-stan: 
	vendor/bin/phpstan analyse src templates

.PHONY: php-cs
php-cs:
	php-cs-fixer fix
 
.PHONY : tailwind-build
tailwind-build:
	symfony console tailwind:build --watch

.PHONY : raz-db
raz-db:
	-- Désactiver les contraintes de clé étrangère
	SET FOREIGN_KEY_CHECKS = 0;

	-- Supprimer toutes les données des tables
	TRUNCATE TABLE pokemon;
	TRUNCATE TABLE pokevolution;
	TRUNCATE TABLE talent;
	TRUNCATE TABLE talent_pokemon;
	TRUNCATE TABLE type;
	TRUNCATE TABLE type_pokemon;

	-- Réactiver les contraintes de clé étrangère
	SET FOREIGN_KEY_CHECKS = 1;

.PHONY :regenerate-db
regenerate-db:
	symfony console doctrine:migrations:diff --from-empty-schema
	symfony console doctrine:migrations:rollup

.PHONY : generate-db
generate-db:
	symfony console doctrine:database:create --if-not-exists
	symfony console doctrine:schema:create
	symfony console doctrine:fixtures:load
