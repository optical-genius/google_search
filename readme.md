## Custom Search API in Laravel

Регистрируемся на https://console.cloud.google.com . Получаем идентификатор пользовательского поиска "cx" и API ключ. Добавляем в env файл строки:

GOOGLE_SEARCH_API_KEY = сюда вставляем API KEY
GOOGLE_SEARCH_SECRET_KEY = сюда идентификатор пользовательского поиска

Ограничение - 100 запросов в сутки.
