SHELL := bin/bash

tests:
    symfony console doctrine:fixtures:load -n
    symfony php bin/phpunit tests/ConferenceControllerTest.php
.PHONY: tests