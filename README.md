# ShelterAPI

Animal shelter API created in PHP

View the full API documentation here:
https://chase-1.gitbook.io/shelterapi/

### Mamp:
- Running on port **3306**

### PhpMyAdmin:
- Create a new database named **shelter**
  - import the **shelter.sql** file
- Set up a new user with all privileges
  - user: mamp
  - pass: mamp

### Setup:

```
composer update
```

### Run in 'public' folder:
```
php -S localhost:8000
```


### Change the baseUrl_API variable in **public/js/index.js** to link to the api folder
```
Change to your apache port and to your destination of the project
In our case, we use http://localhost:8080/I425/Shelter/api
```
