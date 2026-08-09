# BeRewards

BeRewards is a web application for determining rewards for judges and employees of the Lubuk Pakam District Court using a TOPSIS-based decision support process.

The project is built on top of CodeIgniter 3 and uses a light dashboard/authentication interface with custom styling assets.

## Project Overview

BeRewards implements a decision support system that presents a reward management workflow for court personnel. The current codebase includes:

- A login/sign-in flow
- A dashboard layout with administrative UI scaffolding
- Application templates, partials, and custom theme assets
- CodeIgniter routing, controller, config, and library conventions

## Technology Stack

- PHP
- CodeIgniter 3
- MySQL/MariaDB-ready database configuration
- Bootstrap-inspired UI assets and custom CSS/JS front-end assets
- Composer metadata for framework compatibility

## Project Structure

```text
application/
  config/              CodeIgniter configuration and routing
  controllers/         Controllers such as Signin and Dashboard
  views/               UI templates and page content
assets/
  css/                 Theme and custom styling
  js/                  JavaScript assets
  images/              Static image assets
system/                 CodeIgniter runtime files
index.php              Front controller
composer.json          PHP package metadata
```

## Default Routes

The current routing file loads these primary paths:

- `/` or `/signin` → sign-in page
- `/dashboard` → dashboard page

The route definitions are configured in [application/config/routes.php](application/config/routes.php).

## Local Development

### Requirements

- PHP 7+ (compatible with this CodeIgniter 3 framework structure)
- Apache or another web server with PHP support
- MySQL database server
- Composer is optional for this repository, but the project includes composer metadata

### Run Locally

1. Place this project in your web server document root, for example Apache/XAMPP `htdocs`.
2. Configure your database credentials in [application/config/database.php](application/config/database.php).
3. Make sure your web server points to the project root.
4. Access the application through your local URL, for example:

```text
http://localhost/berewards/
```

## Configuration Notes

The main application settings are stored under [application/config/](application/config/):

- [application/config/config.php](application/config/config.php)
- [application/config/database.php](application/config/database.php)
- [application/config/routes.php](application/config/routes.php)

The current database configuration points to a MySQL database named `dss` and expects a local connection with configured credentials.

## Branding

The UI follows the BeRewards brand direction described in [agents/be-rewards-brand-guide.md](agents/be-rewards-brand-guide.md):

- Product name: BeRewards
- Descriptor: Determining the Rewards for Judges and Employees of the Lubuk Pakam District Court With TOPSIS Method
- Primary UI color direction uses a light theme with indigo/cyan accents

## Useful Files

- [application/controllers/Signin.php](application/controllers/Signin.php) – login entry controller
- [application/controllers/Dashboard.php](application/controllers/Dashboard.php) – dashboard entry controller
- [application/views/auth/signin.php](application/views/auth/signin.php) – authentication interface
- [application/views/admin/dashboard.php](application/views/admin/dashboard.php) – dashboard content
- [assets/css/spk-reward.css](assets/css/spk-reward.css) – theme styling

## License

This project is distributed with a CodeIgniter-style project setup and no custom business-license metadata has been declared beyond the existing framework package metadata.
