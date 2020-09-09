# WeBiz

## Installation

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate
    
Run the database migrations and run seeders

    php artisan migrate --seed
    
For first time in production run this in order to generate JWT key       
    
    php artisan jwt:secret
    
Fill google cloud credentials in .env file<br>
Copy google cloud credentials .json file to project base folder
        
    GOOGLE_CLOUD_KEY_FILE=/path/to/project/google_cloud_credentials.json file()

For regenerates the list of all classes & clear cache

    composer dumpauto
    php artisan optimize:clear
