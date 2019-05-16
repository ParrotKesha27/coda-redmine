# Redmine-Coda Sync

Домашнее задание в Академии AERO. Модуль для импорта данных из Redmine в Coda

### Установка

`$ composer require parrotkesha/redmine_sync`

### Использование

1. Создать yaml-файл с конфигурацией. Файл должен содержать параметры для подключения к Redmine и Coda. Ниже приведен шаблон конфигурационного файла:

```
redmine:
  period: <Время, за которое нужно получить данные>
  limit: <Количество получаемых данных>
  url: <URL-адрес Redmine>
  key: <Ключ доступа>

coda:
  token: <API-токен Coda>
  doc: <ID документа>
  table: <Название таблицы>
```  

2. Создать объект класса Synchronization, передав в параметрах путь к yaml-файлу:

`$redmineCoda = new Synchronization(<путь_к_файлу>);`

3. Вызвать метод syncData() для выполнения синхронизации:

`$redmineCoda->syncData();`
