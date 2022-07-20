<h1 align="center">
     
  <a href="https://keymanager.theiotproject.com/"><img src="https://user-images.githubusercontent.com/58706334/179979289-05475ec8-ea13-487b-8c7c-7f8ed0cfeccb.png" alt="KeyManagerLogo" width="100"></a>
    <br>
 Key Manager

 
</h1>

<p align="center">Website application that makes managing & administrating your virtual QR Code keys easier.</p>
<p align="center">Created in Laravel + Vue.js</p>
<p align="center">:star: Star us on GitHub — it motivates us a lot!</p>

<p align="center">
  <a href="">
    <img src="https://img.shields.io/github/commit-activity/w/theiotproject/key-manager">
  </a>
 
  <a href="">
      <img src="https://img.shields.io/tokei/lines/github/theiotproject/key-manager">
  </a>
  <a href="https://theiotproject.com/">
    <img src="https://img.shields.io/badge/visit-blog-green">
  </a>
     <a href=""><img src="https://img.shields.io/github/stars/theiotproject/key-manager?style=social"></a>
</p>

<p align="center">
  <a href="#about">About</a> •
  <a href="#requirements">Requirements</a> •
  <a href="#installation">Installation</a> •
  <a href="#testing">Testing</a> •
  <a href="#contributing">Contributing</a> •
  <a href="#license">License</a>
</p>


## About

### Landing Page

> ![WelcomeCutMac](https://user-images.githubusercontent.com/58706334/180001129-d750bfee-a10a-4747-934b-2bde2e725977.png)



### Dashboard

> <img width="1200" alt="dashboardScreenshot" src="https://user-images.githubusercontent.com/58706334/180000578-36602d08-9d15-413d-86df-45f2190b52ec.png">



## Requirements

Package | Version
--- | ---
[Node](https://nodejs.org/en/) | V14.19.1+
[Npm](https://nodejs.org/en/)  | V6.14.16+ 
[Composer](https://getcomposer.org/)  | V2.2.6+
[Php](https://www.php.net/)  | V8.0.2+
[Mysql](https://www.mysql.com/)  |V 8.0.27+

## Installation

> **Warning**
> Make sure to follow the requirements first.
Here is how you can run the project locally:
1. Clone this repo
    ```sh
    git clone https://github.com/theiotproject/key-manager.git
    ```

1. Go into the project root directory
    ```sh
    cd key-manager
    ```
1. Create database `key_manager` (you can change database name)

1. Install PHP dependencies 
    ```sh
    composer install
    ```

1. Generate key 
    ```sh
    php artisan key:generate
    ```

1. install front-end dependencies
    ```sh
    npm install && npm run dev
    ```

1. Run migration
    ```
    php artisan migrate
    ```
    
1. Run seeder
    ```
    php artisan db:seed
    ```
1. Run server 
    ```sh
    php artisan serve
    ```  

1. Visit `localhost:8000` in your favorite browser.     

    > Make sure to follow your Laravel local Development Environment.

### Environment Variables

1. Copy .env.example file to .env file
    ```sh
    cp .env.example .env
    ```

## Testing
Will be addedd in the future...

## Contributing
Pull requests are welcome.

## License
key-manager is an open-sourced software
