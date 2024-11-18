app_up:
	./vendor/bin/sail up

app_down:
	./vendor/bin/sail down

app_clean:
	./vendor/bin/sail artisan config:clear
	./vendor/bin/sail artisan cache:clear
	./vendor/bin/sail artisan route:clear
	./vendor/bin/sail artisan view:clear

clear_log:
	echo "" > storage/logs/laravel.log


app_route:
	./vendor/bin/sail artisan route:list


db_migrate_fresh:
	./vendor/bin/sail artisan migrate:fresh

db_rollback:
	./vendor/bin/sail artisan migrate:rollback

db_seed:
	./vendor/bin/sail artisan migrate:fresh --seed



test_app:
	./vendor/bin/sail artisan test

test_product:
	./vendor/bin/sail artisan test --filter ProductControllerTest

test_cart:
	./vendor/bin/sail artisan test --filter CartControllerTest

test_order:
	./vendor/bin/sail artisan test --filter OrderControllerTest

