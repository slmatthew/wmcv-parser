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
Получение статистики действия на людей. Возвращает ассоциативный массив с полями `total`, `currently`, `outcome`, `mild`, `critical`, `death`, `recovered`. Четыре последних — `mild`, `critical`, `death` и `recovered` — сами являются ассоциативными массивами с полями `count` и `percent`.

Все значения числовые. Если значение равно `0`, значит эти данные не удалось получить.

```php
$cases = $parser->getCases();
echo "Инфицировано: {$cases['currently']}";
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
The statistics of the actions on people. Returns associative array with this fields: `total`, `currently`, `outcome`, `mild`, `critical`, `death`, `recovered`. Last 4 values are associative arrays with `count` and `percent` fields.

Every value is integer. If value == `0` this value have not been got.

```php
$cases = $parser->getCases();
echo "Infected people: {$cases['currently']}";
```

### getCountries
Get countries where is infected people. Returns array with associative array with this fields: `name` (country name), `cases` (count of infected people), `deaths` (count of deaths), `region` (Asia, Europe etc.)

```php
$countries = $parser->getCountries();
echo "First country in the list: {$contries[0]['name']}";
```