# Proyecto de M7
Propuesta de solución al proyecto dentro del módulo de M7 de 2do de DAW.
  
## Preparación de entorno
Clona el directorio del proyecto:

    git clone https://github.com/juditmaria/project-m7.git

Instala las **dependencias de Composer** que *no se incluyen en el control de versiones* debido a las restricciones establecidas en el archivo **.gitignore**:

    php .././composer install

Instalar e iniciar npm

    npm install
    npm audit fix
    npm run dev

Enlazar las carpetas donde se guardan los archivos

    php artisan storage:link 

En caso de usar sqlite habrá que crear en */laravel/database* el archivo *database.sqlite*. Con los comandos de migrate de php podremos hacer y desacer las tablas del proyecto.

Comandos de migrate:
  php artisan migrate:status
  php artisan migrate
  php artisan migrate:rollback
  php artisan migrate:fresh

Al iniciar el proyecto por primera vez ejecutaremos las migraciones para la creación de la base de datos:
 **php artisan migrate**

Creacion del archivo **.env**:

    nano .env

Ejemplo del código .env esperado:

    APP_NAME=Laravel
    APP_ENV=local
    APP_KEY=base64:QSh0sW0vhZSrDMKDOPrnKAqAJKAPjO9eMsV34eo17G4=
    APP_DEBUG=true
    APP_URL=http://localhost
    
    LOG_CHANNEL=stack
    LOG_DEPRECATIONS_CHANNEL=null
    LOG_LEVEL=debug
    
    DB_CONNECTION=sqlite  
    DB_DATABASE=../database/database.sqlite
    
    # DB_CONNECTION=mysql
    # DB_HOST=**host**
    # DB_PORT=3306
    # DB_DATABASE=**username**
    # DB_USERNAME=**username**
    # DB_PASSWORD=**password**
    
    BROADCAST_DRIVER=log
    CACHE_DRIVER=file
    FILESYSTEM_DISK=local
    QUEUE_CONNECTION=sync
    SESSION_DRIVER=file
    SESSION_LIFETIME=120
    
    MEMCACHED_HOST=127.0.0.1
    
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379
    
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=**mail**
    MAIL_PASSWORD=**password**
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=**mail**
    MAIL_FROM_NAME="${APP_NAME}"
    
    AWS_ACCESS_KEY_ID=
    AWS_SECRET_ACCESS_KEY=
    AWS_DEFAULT_REGION=us-east-1
    AWS_BUCKET=
    AWS_USE_PATH_STYLE_ENDPOINT=false
    
    PUSHER_APP_ID=
    PUSHER_APP_KEY=
    PUSHER_APP_SECRET=
    PUSHER_HOST=
    PUSHER_PORT=443
    PUSHER_SCHEME=https
    PUSHER_APP_CLUSTER=mt1
    
    VITE_APP_NAME="${APP_NAME}"
    VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
    VITE_PUSHER_HOST="${PUSHER_HOST}"
    VITE_PUSHER_PORT="${PUSHER_PORT}"
    VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
    VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
    
    ADMIN_NAME=**username**
    ADMIN_EMAIL=**mail**
    ADMIN_PASSWORD=**password**

Configuración de */laravel/config/database.php* para forzar a usar la ruta "../database/database.sqlite" para conectar con la base de datos:

    'sqlite' => [
                'driver' => 'sqlite',
                'url' => env('DATABASE_URL'),
                'database' => env('DB_CONNECTION') === 'sqlite' ? database_path(env('DB_DATABASE', 'database.sqlite')) : env('DB_DATABASE', database_path('database.sqlite')),
                'prefix' => '',
                'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
            ],
