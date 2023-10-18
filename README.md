# Laravel - PHPDoctrine

## Iniciar proyecto laravel
```composer create-project laravel/laravel proyecto```

## Instalar doctrine
```composer require laravel-doctrine/orm```

### Activamos la configuracion
```php artisan vendor:publish --tag="config"```

## Para crear la BD
```php artisan doctrine:schema:create```

### Para limpiar la BD
```php artisan doctrine:schema:drop```
