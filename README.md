# Laravel Command Generator
To make it easier to make commands in laravel and can already be used with .stub files

## How to use
1. Paste file `CommandGenerator.php` to `App\Console\Commands`
2. Replace `CommandGenerator` class to `YourClass`
3. Rename the file accordingly
4. if your command interact with file .stub create file stub in `App\Console\stubs`
5. Edit property in file `CommandGenerator.php`

### Example code
```php
/**
 * The name and signature of the console command.
 *
 * @var string
 */
protected $signature = 'make:enum {name}'; // {name} don't change it
```

```php
/**
 * The console command description.
 *
 * @var string
 */
protected $description = 'Create spatie enum';
```

`app/Console/stubs/create-enum.stub`
```php
/**
 * the stub file path
 * 
 * @var string
 */
protected $stubFile = 'create-enum';
```

`app/Console/stubs/create-enum.stub`

```php
/**
 * the stub file path
 * 
 * @var string
 */
protected $stubFile = 'create-enum';
```

```php
/**
 * the class namespace
 * 
 * @var string
 */
protected $namespace = 'App\\Enums';
```

```php
/**
 * the path of generate file
 * 
 * @var string
 */
protected $pathGenerateFile = 'app/Enums';
```
