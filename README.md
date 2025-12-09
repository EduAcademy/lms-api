
# Final Year Project - EduAcademy

This repository contains the Backend of our Final Year Project.

## Other parts:
- [Frontend](https://github.com/EduAcademy/lms-client)
- [Documentation](https://github.com/EduAcademy/LMS-Project-Documentation)

Please refer to these links for the complete project.


# LMS - API

This is the back-end client for the Learning Management System (LMS). It is built using Laravel.

## Features

-   API endpoints for LMS functionality.
-   User authentication and session management.
-   Database migrations for managing the application's schema.

## Installation

Follow the steps below to install and run the project locally.

### Prerequisites

Ensure you have the following installed:

-   PHP (>=8.0)
-   Composer
-   MySQL or any supported database
-   Laravel Framework

### Clone the Repository

```bash
git clone https://github.com/EduAcademy/lms-api.git
cd lms-api
```

### Install Dependencies

Run the following command to install the necessary dependencies:

```bash
composer install
```

### Environment Setup

Create a `.env` file by copying the `.env.example` file and updating it with your local environment variables:

```bash
cp .env.example .env
```

### Generate Application Key

Generate the application key using the following command:

```bash
php artisan key:generate
```

### Run Database Migrations

Ensure your database configuration in the `.env` file is correct, then run the migrations:

```bash
php artisan migrate
```

## Usage

To start the development server and run the project locally, execute:

```bash
php artisan serve
```

Visit the local server URL (e.g., `http://127.0.0.1:8000`) in your browser or API client.

## Testing the API

You can use tools like [Postman](https://www.postman.com/) or [cURL](https://curl.se/) to test the API endpoints.

## Contributing

Contributions are welcome! Please follow the guidelines below:

1. Fork the repository.
2. Create a new branch for your feature or bug fix.
3. Submit a pull request with a detailed description of your changes.

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.


