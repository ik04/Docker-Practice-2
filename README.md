# Auth Api

A Project made using php and laravel for Scc recruitments 2023

# Installation

- Install Php and xampp for windows [here](https://www.apachefriends.org/)

- Install Composer for windows [here](https://getcomposer.org/)
- to install Laravel, run the following after installing composer
```bash
composer global require laravel/installer
```

- Run mysql and apache on the xampp panel (setup root with no password)

paste the following to initialize (run on git bash):

```bash
git clone https://github.com/ik04/Scc-Task.git
cd Scc-Task
composer install
cp .env.example .env
php artisan migrate
php artisan serve
```



# Usage
After setup you can now interact with the different routes of the Api
- All routes Are defined in the routes folder (routes/api.php)
- The code for function of each route is in the Usercontroller (app/http/Controllers/UserController.php)
- Start the server with:
```bash 
php artisan serve
```



# Routes and Outputs:
![Screenshot from 2023-04-06 11-38-21](https://user-images.githubusercontent.com/63468587/230293974-1f946f71-3e46-410c-a6cf-216afac6eec3.png)

## healthcheck (http://localhost:8000/api/healthcheck):
![healthcheck](https://user-images.githubusercontent.com/63468587/230306040-d9fe166b-bdec-478d-8eee-c4ac6609645c.png)

## signup (http://localhost:8000/api/signup):
![signup](https://user-images.githubusercontent.com/63468587/230306248-69c43df7-0137-427e-bc9a-b2f538bc6aa5.png)

## login (http://localhost:8000/api/login):
![login](https://user-images.githubusercontent.com/63468587/230306324-f28e1efa-902c-47f1-bc87-ce9fc585fd7b.png)

## register-admin (http://localhost:8000/api/register-admin):
![admin-sign-up](https://user-images.githubusercontent.com/63468587/230306468-3224a2a0-be07-44da-91e8-928d7ba13b0d.png)

## list users (http://localhost:8000/api/users):
![user-list](https://user-images.githubusercontent.com/63468587/230306683-c1d61cc4-9d5d-4abd-ae62-51bb0145dfde.png)

## users created in last hours (http://localhost:8000/api/users/:hours):

example 1:
![hours1](https://user-images.githubusercontent.com/63468587/230307019-d921cb18-8f47-4824-8027-fc93a655d0a8.png)

example 2:
![hours2](https://user-images.githubusercontent.com/63468587/230307134-fa4e4ed6-5ddc-4ff0-8ddd-3aef452c2a15.png)

## Search User (http://localhost:8000/api/user/:id):
![search-by-id](https://user-images.githubusercontent.com/63468587/230307403-386d1822-ce0e-4139-aec3-32cedf6e395f.png)

## Delete user (http://localhost:8000/api/user/:id):
non admin user trying to delete other accounts:
![unauthorized](https://user-images.githubusercontent.com/63468587/230307673-7deea36e-e663-493a-9c60-0672775aa76e.png)

User deleting their own account:
![ownaccdel](https://user-images.githubusercontent.com/63468587/230307884-aabcd6d7-5e8b-42d6-ba0d-281d34b42bec.png)

Admin login:
![admin-login](https://user-images.githubusercontent.com/63468587/230308179-9a0e8e4c-82b0-412e-a9b8-39cdf8690a49.png)

Admin deleting an account:
![admindelsacc](https://user-images.githubusercontent.com/63468587/230308284-04688a68-e2dc-46fb-ae06-65dc850335e0.png)

## logout (http://localhost:8000/api/logout):
Shows the name of the user logging out
![logout](https://user-images.githubusercontent.com/63468587/230308760-29956e40-5228-46e4-a34c-4df8f8ba4df3.png)



## Precautions
- Input yes to creating scc_task db during the "php artisan migrate" command
- Please send your requests on http://127.0.0.1:8000/api/ [route-param / name]
- Make sure to put in Accept Header (Accept: application/json)
- # For all authorized routes (users, users/{hours}, user/{id} and logout) put the Login token in the Authorization Header:
 ![token](https://user-images.githubusercontent.com/63468587/230308842-bd250033-5bca-46c2-9189-5eaa9d6a9b0b.png)


