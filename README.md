# Medical Exam Tracker 🇬🇧 / 🇵🇱

*(Scroll down for Polish version / Polska wersja poniżej)*

## 🇬🇧 English Version

A medical application for tracking exams and parameters, based on the latest technology stack: PHP 8.5 and Symfony 8.0.7.

### Features
* Medical exams management (Exam)
* Tracking parameters per exam (Parameters)
* TDD-driven (Full PHPUnit coverage) with built-in DB cleaning (DAMA Test Bundle)
* Full automated code analysis in CI (GitHub Actions)
* PostgreSQL 16 database
* GUI based on clean HTML5 (semantic tags) using Bootstrap and SCSS compiling

### Requirements
* Docker & Docker Compose
* (Optional) PHP 8.5 on local machine

### Setup Instructions (Local/Docker)

1. Clone the project and enter the `medical-exam-tracker` directory.
2. Start containers using docker:
   ```bash
   docker compose up -d
   ```
3. Build Composer packages (inside the `php` container):
   ```bash
   docker compose exec php composer install
   ```
4. Prepare structure and execute DB migrations in the dev environment:
   ```bash
   # Or use shortcut: composer db:migrate
   docker compose exec php bin/console doctrine:database:create --if-not-exists
   docker compose exec php bin/console doctrine:migrations:migrate -n
   ```
5. Seed the database (Fixtures):
   ```bash
   # Or use shortcut: composer db:fixtures
   docker compose exec php bin/console doctrine:fixtures:load -n
   ```

The application will be available at: [http://localhost:8000](http://localhost:8000)

---

## 🇵🇱 Polska Wersja

Aplikacja medyczna do śledzenia badań oraz parametrów, oparta o najnowszy stack technologiczny PHP 8.5 i Symfony 8.0.7.

### Funkcjonalności
* Zarządzanie badaniami medycznymi (Exam)
* Śledzenie parametrów na badanie (Parameters)
* TDD-driven (Pełne pokrycie testami PHPUnit) z wbudowanym czyszczeniem BD (DAMA Test Bundle)
* Pełna automatyczna analiza kodu w CI (GitHub Actions)
* Baza danych PostgreSQL 16
* Interfejs graficzny oparty o czystego HTML5 (tagi semantyczne) z wykorzystaniem Bootstrap i kompilacji SCSS

### Wymagania
* Docker & Docker Compose
* (Opcjonalnie) PHP 8.4 na systemie lokalnym

### Instrukcja Uruchomienia (Local/Docker)

1. Sklonuj projekt i wejdź do katalogu `medical-exam-tracker`.
2. Uruchom kontenery przy użyciu dockera:
   ```bash
   docker compose up -d
   ```
3. Zbuduj pakiety Composer (wewnątrz kontenera `php`):
   ```bash
   docker compose exec php composer install
   ```
4. Przygotuj strukturę i wykonaj migracje BD w środowisku developerskim:
   ```bash
   # Lub użyj skrótu: composer db:migrate
   docker compose exec php bin/console doctrine:database:create --if-not-exists
   docker compose exec php bin/console doctrine:migrations:migrate -n
   ```
5. Zasil bazę danymi (Fixtures - paczka testowych wyników medycznych):
   ```bash
   # Lub użyj dodanego skrótu: composer db:fixtures
   docker compose exec php bin/console doctrine:fixtures:load -n
   ```

Aplikacja dostępna będzie pod adresem: [http://localhost:8000](http://localhost:8000)

### Ciągła Integracja i Testowanie
Logika CI jest w `.github/workflows/ci.yml`. Upewnij się przed pushem, że komendy analizy statycznej (`composer phpstan`), naprawy stylu kodu (`composer cs:fix`) oraz główna komenda z testami izolowanymi TDD (`composer test`) kończą się sukcesem.

