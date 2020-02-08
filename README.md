# Worldometers Coronavirus parser
Парсер страницы [случаев](https://www.worldometers.info/coronavirus/) Уханьского коронавируса и [стран, где он распространился](https://www.worldometers.info/coronavirus/countries-where-coronavirus-has-spread/).

Class for parsing Worldometers pages about Wuhan coronavirus: [cases](https://www.worldometers.info/coronavirus/) and [countries where coronavirus has spread](https://www.worldometers.info/coronavirus/countries-where-coronavirus-has-spread/).

## Использование
Подключите файл в свой проект и создайте экземпляр класса `WmParser`:

```php
include 'parser.php';
$parser = new WmParser();
```

### getCases
Получение количества инфицированных, в тяжелом состоянии, умерших и выздоровевших. Возвращает ассоциативный массив с полями `infected`, `critical`, `death`, `recovered`. Все значения числовые. Если значение равно `-1`, значит эти данные не удалось получить.

```php
$cases = $parser->getCases();
echo "Инфицировано: {$cases['infected']}";
```

### getCountries
Получить список стран, в которых есть инфицированные люди. Возвращает массив ассоциативных массивов с полями `name` (название страны), `cases` (сколько инфицированных), `deaths` (сколько умерло), `region` (Азия, Европа и т.д.)

```php
$countries = $parser->getCountries();
echo "Первая страна в списке: {$contries[0]['name']}";
```

## How to use
Include `parsers.php` in your project and create an instance of the `WmParser` class:

```php
include 'parser.php';
$parser = new WmParser();
```

### getCases
Get count of infected, critical, death and recovered cases. Returns associative array with this fields: `infected`, `critical`, `death`, `recovered`. Every value is integer. If value == `-1` this value have not been got.

```php
$cases = $parser->getCases();
echo "Infected people: {$cases['infected']}";
```

### getCountries
Get countries where is infected people. Returns array with associative array with this fields: `name` (country name), `cases` (count of infected people), `deaths` (count of deaths), `region` (Asia, Europe etc.)

```php
$countries = $parser->getCountries();
echo "First country in the list: {$contries[0]['name']}";
```