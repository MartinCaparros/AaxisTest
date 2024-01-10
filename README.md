Instructions:

1- Run in the console the command composer install first and then npm install, to properly install all the required dependencies.
2- Run docker compose up -d to run the DB in Docker Desktop.
3- If you dont have symfony CLI you can install it:
    - Using CURL : curl -sS https://get.symfony.com/cli/installer | bash
    - Using Homebrew: brew install symfony-cli/tap/symfony-cli
4- After installing run this command to properly link to your shell configuration file: export PATH="$HOME/.symfony/bin:$PATH"
5- Copy and paste the .env.test file and remove the .test sufix.
5- Run "symfony console server:start" to initiate the application locally
6- Run "symfony console doctrine:database:create" to link the application to the docker DB instance.
7- Run "symfony console doctrine:migrations:migrate" to create the necessary tables
8- Run "symfony console doctrine:fixtures:load" to populate the product table.
9- Run "php bin/console lexik:jwt;:generate" to create the JWT pems. 


To compile js:

1- npm run dev --watch (this will keep compiling on the flight)

To compile tailwind: 

1- npx tailwindcss -i ./assets/styles/app.css -o ./public/build/app.css --watch


The available services are: 

- /api/register
- /api/login-check
- /api/products
- /api/products/store
- /api/products/update
- /api/products/delete

1- First you have have to register using an email and a password
2- After with those credentials you can send a POST request to login-check endpoint, using your password and your email as username. With the returned token you can perform all the request needed using Bearer authentication.