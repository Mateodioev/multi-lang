# Multi-lang

A simple package to manage multi-language in your project.

## Installation

```bash
composer require mateodioev/multi-lang
```

## Usage

- Create a directory to save your language files, for example `resources/lang`.

- Create a file for each language you want to support, for example `en.json` and `es.json`.

File `en.json`:
```json
{
    "english_name": "English",
    "name": "English",
    "data": {
        "welcome": "Welcome {full_name} to our website",
        "goodbye": "Goodbye dear {full_name}"
    }
}
```

File `es.json`:
```json
{
    "english_name": "Spanish",
    "name": "Español",
    "data": {
        "welcome": "Bienvenido {full_name} a nuestro sitio web",
        "goodbye": "Adiós querido {full_name}"
    }
}
```

- Configure the dir

```php
use Mateodioev\MultiLang\Cache\InMemoryCache;
use Mateodioev\MultiLang\Lang;

Lang::setup(
    dir: __DIR__ . '/resources/lang',
    cache: new InMemoryCache() // Optional
);
```

- Format the strings

```php
// If the key does not exist it will return null
Lang::get('es')->data('welcome')?->format(['full_name' => 'Mateo']);
// Output: Bienvenido Mateo a nuestro sitio web
```

## File format
- `english_name`: The name of the language in English.
- `name`: The name of the language in its own language.
- `data`: The key-value pairs of the language strings.
  - `key`: The key of the string.
  - `value`: The value of the string. You can use placeholders to replace them with values.
> WARNING: If the json file does not contain any of these keys or different data it will give an error.

## Validate the files

You can validate the files to check if they have the correct format.
> WARNING: Not use in production. This load and parse all the files
```php
Lang::compareData();
```
