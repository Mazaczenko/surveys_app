<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Na początek

1. composer i

2. npm i

3. Create .env file
    - DB_CONNECTION=mysql

4. php artisan key:generate

5. create DB and update .env file with it's name

6. php artisan migrate

7. php artisan db:seed

8. php artisan serve

9. npm run dev


"/" -> Ścieżka do nowej ankiety 

"/list" -> Ścieżka do listy ankiet


## Funkcje

1. W widoku listy wypełnionych ankiet wyświetlamy tylko w pełni ukończone ankiety

2. Formularz nowej ankiety posiada mechanizm zapisywania częściowych wyników. Jego mechanizm działa następująco:

    - kliknięcie w przycisk "dalej" zapisuje odpowiedź dla konkretnego podejścia, ankiety, i pytania

    - zmiana odpowiedzi na pytanie i jej zatwierdzenie przyciskiem "dalej" nadpisuje wcześniejszą odpowiedź

    - ukończenie ankiety ustawia is_comopleted = 1 dla danego podejścia

    - nieukończone podejścia i ich częściowe odpowiedzi nie są wyświetlane na liście uzupełnionych ankiet
