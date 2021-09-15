#Configuration

преопределение штатного класса сущности


#CQRS model

Actions в контроллере разбиты на две группы
создание, редактирование, удаление данных

        1. putAction(PUT), postAction(POST), deleteAction(DELETE)
получение данных

        2. getAction(GET), criteriaAction(GET)
    
каждый метод работает со своим менеджером

        1. CommandManagerInterface
        2. QueryManagerInterface

При преопределении штатного класса сущности, дополнение данными осуществляется декорированием, с помощью MediatorInterface


группы  сериализации
    

статусы:

    создание:
        код создан HTTP_CREATED 201
    обновление:
        код обновление HTTP_OK 200
    удаление:
        код удален HTTP_ACCEPTED 202
    получение:
        код(ы) найдены HTTP_OK 200
    ошибки:
        если код не найден CodeNotFoundException возвращает HTTP_NOT_FOUND 404
        если код не уникален UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если код не прошел валидацию CodeInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если код не может быть сохранен CodeCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400


Тесты:
    
    composer install --dev
    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap tests/bootstrap.php --configuration phpunit.xml.dist tests --teamcity


