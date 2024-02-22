## Sobre

Sistema de cadastro de solicitações de esterilização de animais (cães e gatos) desenvolvido para a UVZ (unidade Vetéria e de Zoonoses).

## Built With

- [Laravel 10.x](https://laravel.com/docs/10.x)
- [Bootstrap 5](https://getbootstrap.com/docs/5.0/getting-started/introduction/)

## Prerequisites

The requirements to run this system can be found at the link: [documentação oficial do laravel](https://laravel.com/docs/10.x):

- Laravel 10.x requires a minimum PHP version of 8.1
- Enable extension=gd extension in php.ini (for captcha)
- Enable extension=zip extension in php.ini (for captcha)

## Dependencies

- [Captcha for Laravel](https://github.com/mewebstudio/captcha), Note: Enable extension=gd extension in php.ini
- [Laravel DomPdf](https://github.com/barryvdh/laravel-dompdf)
- [laravel excel export lib](https://laravel-excel.com/)
- [bootstrap-datepicker](https://github.com/uxsolutions/bootstrap-datepicker)
- [Inputmask](https://github.com/RobinHerbots/Inputmask)

## Installation

### Clone the repository

```
git clone https://github.com/erisilva/acl80.git
```

Use composer to install project dependencies:

```
composer update
```

### Create the database

This configuration shown below uses MySQL as the database. This configuration is for a development environment, therefore not recommended for production.

```
CREATE DATABASE database_name_here CHARACTER SET utf8 COLLATE utf8_general_ci;
```

### Configure the environment

Create the settings .env file:

```
php -r "copy('.env.example', '.env');"
```

Edit the .env file in the root folder of the project with the database configuration data. More info in [documentação oficial do laravel](https://laravel.com/docs/10.x/configuration#environment-configuration):
    
```
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=database_name_here
DB_USERNAME=your_username_here
DB_PASSWORD=yout_password_here
```

### Generate the application key

```
php artisan key:generate
```
### Configure the storage if necessary

```
php artisan storage:link
```

### Migration

Executar a migração das tabelas com o comando seed:

```
php artisan migrate --seed
```

### Language

The default language is Brazilian Portuguese. To change the language, edit the file config/app.php:

```
'locale' => 'en',
```

## Usage

To run the system, use the command:

```
php artisan serve
```
Access the application in your web browser by visiting http://localhost:8000 or the appropriate URL provided by the php artisan serve command.

### Users

Login: adm@mail.com 
Login: gerente@mail.com 
Login: operador@mail.com
Login: leitor@mail.com

Note: The password for all users is 123456. By default, the migration generates users with names in Brazilian Portuguese.

## Contact

- E-mail: erivelton.silva@proton.me
- Discord: gixeph#0658

## Contribution

If you would like to contribute to this project, I welcome your suggestions, bug reports, and pull requests. Please fork the repository, make your changes, and submit a pull request outlining your modifications.

## Future Enhancements

Here are some potential areas for future development and enhancement of this web application:

-Implementing additional authentication methods such as OAuth or Two-Factor Authentication (2FA) for enhanced security.
- Extending reporting capabilities to include additional file formats and advanced data visualization options.
- Enhancing the logging system to provide more detailed information, including IP address and timestamp, for better traceability of events.
- Expanding language support to include more languages

## Licenças

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details, except for the libraries used.

## Acknowledgments

- [Laravel](https://laravel.com/)
- [Bootswatch](https://bootswatch.com/)
