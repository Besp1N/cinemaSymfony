
# Cinema Project

Welcome to our Symfony-powered cinema application! This feature-rich platform combines Symfony and JavaScript to deliver an immersive movie-going experience. Users can explore a diverse movie catalog with the search functionality, reserve seats for upcoming screenings, and create accounts for a personalized journey through the world of cinema. Account activation is facilitated through a confirmation email sent using the integrated mailer.

The application utilizes a MySQL database to store crucial information, including user data, movie details, and reservation records. A dynamic map feature showcases the geographical locations of cinemas, providing users with a visual representation based on the movie localization property.


## Authors

- [@Kacper Karabinowski](https://github.com/Besp1N)
- [@Klaudiusz Petryk](https://github.com/PendolinoVoyager)


## Installation

Install our project 

```bash
  git clone https://github.com/Besp1N/cinemaSymfony.git
  symfony server:start
```
    - Or you can use Nginx server with this config:
```bash
server {
    server_name 192.168.64.4 localhost;
    root /var/www/cinema/public;

    location / {
        try_files $uri /index.php$is_args$args;
    }


    location ~ ^/index\.php(/|$) {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;


        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        #To naprawilo serwer
        fastcgi_buffer_size 128k;
        fastcgi_buffers 4 256k;
        fastcgi_busy_buffers_size 256k;
        # fastcgi_param APP_ENV dev;
        # fastcgi_param APP_SECRET 644d59af7acd47f573f0956aa4426613;
        # fastcgi_param DATABASE_URL "mysql://cinema_user:1234@host:3306/cinema";
        #################

        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
       internal;
    }

    location ~ \.php$ {
        return 404;
    }

    error_log /var/log/nginx/project_error.log;
    access_log /var/log/nginx/project_access.log;
    proxy_buffer_size   128k;
    proxy_buffers   4 256k;
    proxy_busy_buffers_size   256k;
}
```

- To load defaulf database entities use:
```bash
Symfony doctrine:fixtures:load 
```



    
