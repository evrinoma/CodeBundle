#Configuration

    contractor:
        db_driver: orm модель данных
        factory_code: App\Code\Factory\CodeFactory фабрика для создания объекта кода, 
                 не достающие значения можно разрешить на уровне Mediator или переопределив фабрику 
        factory_bunch: App\Code\Factory\BunchFactory фабрика для создания объекта группы, 
                 не достающие значения можно разрешить на уровне Mediator или переопределив фабрику 
        entity_code: App\Code\Entity\Code сущность кода
        entity_bunch: App\Code\Entity\Code сущность группы
        constraints_code: - включить валидацию по умолчанию для кода
        constraints_bunch:- включить валидацию по умолчанию для группы
        dto_code: App\Code\Dto\CodeDto класс dto с которым работает сущность кода
        dto_bunch: App\Code\Dto\BunchDto класс dto с которым работает сущность группы
        decorates:
          command_code - декоратор команд кода
          query_code - декоратор запросов кода
          command_bunch - декоратор команд группы
          query_bunch - декоратор запросов группы


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
Медиатор доступен только для Code и Bunch сущностей

группы  сериализации

        api_get_code_code, api_post_code_code, api_put_code_code
        api_get_code_bunch, api_post_code_bunch, api_put_code_bunch
        api_get_code_type, api_post_code_type, api_put_code_type
        api_get_code_owner, api_post_code_owner, api_put_code_owner

#Статусы:
release 1.0.0
коды объединяются в группы у каждой группы есть свой тип у каждого кода есть свой владелец

release 2.0.0
у каждого кода есть свой тип и есть свой владелец
у каждой группы есть свой тип
коды объединяются в группы в промежуточной таблице


сущность Code 

    создание:
        код создан HTTP_CREATED 201
    обновление:
        код обновление HTTP_OK 200
    удаление:
        код удален HTTP_ACCEPTED 202
        при удалениисущность помечается как d
    получение:
        код(ы) найдены HTTP_OK 200
    ошибки:
        если код не найден CodeNotFoundException возвращает HTTP_NOT_FOUND 404
        если код не уникален UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если код не прошел валидацию CodeInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если код не может быть сохранен CodeCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

сущность Bunch

    создание:
        код создан HTTP_CREATED 201
    обновление:
        код обновление HTTP_OK 200
    удаление:
        код удален HTTP_ACCEPTED 202 
        при удалениисущность помечается как d
    получение:
        код(ы) найдены HTTP_OK 200
    ошибки:
        если группа не найдена BunchNotFoundException возвращает HTTP_NOT_FOUND 404
        если группа не уникалена UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если группа не прошла валидацию BunchInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если группа не может быть сохранен BunchCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

сущность Owner

    создание:
        код создан HTTP_CREATED 201
    обновление:
        код обновление HTTP_OK 200
    удаление:
        код удален HTTP_ACCEPTED 202
    получение:
        код(ы) найдены HTTP_OK 200
    ошибки:
        если владалец не найден OwnerNotFoundException возвращает HTTP_NOT_FOUND 404
        если владалец не уникален UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если владалец не прошел валидацию OwnerInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если владалец не может быть сохранен OwnerCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

сущность Type

    создание:
        код создан HTTP_CREATED 201
    обновление:
        код обновление HTTP_OK 200
    удаление:
        код удален HTTP_ACCEPTED 202
    получение:
        код(ы) найдены HTTP_OK 200
    ошибки:
        если тип не найден TypeNotFoundException возвращает HTTP_NOT_FOUND 404
        если тип не уникален UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если тип не прошел валидацию TypeInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если тип не может быть сохранен TypeCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

#Тесты:
    
    composer install --dev
    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests/Functional/Controller/ --teamcity

