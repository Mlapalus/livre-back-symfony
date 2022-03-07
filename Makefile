.PHONY: lint

lint:
	vendor/bin/phpstan
	bin/console lint:container
	vendor/bin/phpcs --standard=PSR12 src tests/domain domain

tests-unit:
	bin/phpunit