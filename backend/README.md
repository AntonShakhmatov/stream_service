# Local development

## Setup

If running the project for the first time, install composer dependencies, which installs [Laravel sail](https://laravel.com/docs/10.x/sail)

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

Configure [shell alias](https://laravel.com/docs/10.x/sail#configuring-a-shell-alias), otherwise everywhere there is `sail`, use `./vendor/bin/sail`

Start the containers php, redis, mysql, mongodb
```bash
sail up
```

Application runs on `localhost:8003`
