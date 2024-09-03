# Laravel WEBSITEBANHANG

## System Requirements

- PHP >= 8.1
- Composer
- MySQL or any other database supported by Laravel
## Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/DuyVu2806/websitebanhang.git
    cd project
    ```

2. **Install Composer dependencies:**

    ```bash
    composer install
    ```

3. **Configure the `.env` file:**

    Create a `.env` file from the `.env.example` and update the necessary settings:

    ```bash
    cp .env.example .env
    ```

    Update environment variables like `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.

4. **Generate the application key:**

    ```bash
    php artisan key:generate
    ```

5. **Run migrations and seeders:**

    ```bash
    php artisan migrate --seed
    ```

6. **Serve the application:**

    ```bash
    php artisan serve
    ```

    You can now access the project at `http://localhost:8000`.

## Usage

- Instructions on how to use the main features of the application.
- Provide examples and screenshots if necessary.

