Результат выполнения тестового задания.

1. Хотел воспользоваться Docker, но возникала ошибка при поднятии контейнера, т.к. не мог загрузить некоторые изображения (?) (якобы интернет слабый). Среда разработки состояла из MySQL версии 8.0.26 и встроенного PHP сервера версии 8.0.11.
2. Файл .env не редактировал. Был создан новый юзер webmaster, наделённый всеми правами к базе данных slim_project.
3. Базу данных создал вручную, для добавления и заполнения полей таблицы movie использовал встроенную команду ./bin/console orm:schema-tool:create.
4. Получение записей осуществлял встроенной командой ./bin/console fetch:trailers, которую отредактировал под получение десятка записей вместо всех доступных. Имейте ввиду, повторный запуск команды может привести к увеличению количества записей в БД.
5. Над вёрсткой не заморачивался, воспользовался встроенным Bootstrap 4.
6. Добавил сноску внизу страницы с решениями заданий уровня junior.