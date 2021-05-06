# WeBiz

## Installation

-   This project is docker compatible, To run this project on your docker environment.
    -   Run **docker-compose up --build** on your repository root directory to create docker containers.
    -   Make sure all containers are running before continuing.
    -   Run **docker exec -it webiz bash** to run php container
    -   and then run following **commands** 1 by 1
        -   **ccomposer install**
        -   **cp .env.example .env**
        -   **php artisan key:generate**
        -   **php artisan migrate --seed**
        -   **php artisan jwt:secret**

Fill google cloud credentials in .env file<br>
Copy google cloud credentials .json file to project base folder

    GOOGLE_CLOUD_KEY_FILE=/path/to/project/google_cloud_credentials.json file()
