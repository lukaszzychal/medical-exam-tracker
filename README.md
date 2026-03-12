# Medical Exam Tracker

Aplikacja medyczna do śledzenia badań oraz parametrów, oparta o najnowszy stack technologiczny PHP 8.4 i Symfony 8.

## Funkcjonalności
* Zarządzanie badaniami medycznymi (Exam)
* Śledzenie parametrów na badanie (Parameters)
* TDD-driven (Pełne pokrycie testami PHPUnit) z wbudowanym czyszczeniem BD (DAMA Test Bundle)
* Pełna automatyczna analiza kodu w CI (GitHub Actions)
* Baza danych PostgreSQL 16
* Interfejs graficzny oparty o czystego HTML5 (tagi semantyczne) z wykorzystaniem Bootstrap

## Wymagania
* Docker & Docker Compose
* (Opcjonalnie) PHP 8.4 na systemie lokalnym

## Instrukcja Uruchomienia (Local/Docker)

1. Sklonuj projekt i wejdź do katalogu `medical-exam-tracker`.
2. Uruchom kontenery przy użyciu dockera:
   ```bash
   docker compose up -d
   ```
3. Zbuduj pakiet pakietów Composer (wewnątrz kontenera `php`):
   ```bash
   docker compose exec php composer install
   ```
4. Przygotuj strukturę i wykonaj migracje BD w środowisku developerskim:
   ```bash
   docker compose exec php bin/console doctrine:database:create --if-not-exists
   docker compose exec php bin/console doctrine:migrations:migrate -n
   ```
5. Zasil bazę danymi (Fixtures):
   ```bash
   docker compose exec php bin/console doctrine:fixtures:load -n
   ```

Aplikacja dostępna będzie pod adresem: [http://localhost:8000](http://localhost:8000)

## Testowanie (Automatyczne upewnianie spójności kodu)
Przed wrzuceniem kodu do repozytorium należy upewnić się o przejściu testów:
```bash
# Style (Fix) - PHP-CS-Fixer
docker compose exec php vendor/bin/php-cs-fixer fix

# Analiza Statyczna kodu
docker compose exec php vendor/bin/phpstan analyse

# Testy Funkcjonalne / TDD (DAMA Test Bundle w środku dla płynnego izolowanego resetu db)
docker compose exec php bin/phpunit
```

## Ciągła Integracja
Logika CI jest w `.github/workflows/ci.yml`. Uruchamia ona środowisko PostgreSQL w tle oraz wykorzystuje te same reguły co w lokalnym testowaniu. Wszelkie Pushe i Pull Requesty będą sprawdzane na zgodność z zasadami TDD/Clean Code.
