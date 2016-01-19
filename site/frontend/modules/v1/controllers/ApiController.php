<?php

namespace site\frontend\modules\v1\controllers;

use site\frontend\modules\v1\components\V1ApiController;

class ApiController extends V1ApiController
{
    #region Actions
    public function actions()
    {
        return array(
            /**
             * @apiDefine SimpleAuthInstruction
             * @apiParam (Simple Login/Password Params:) {String} auth_email Email пользователя.
             * @apiParam (Simple Login/Password Params:) {String} auth_password Пароль пользователя.
             */
            /**
             * @apiDefine SocialAuthInstruction
             * @apiParam (Social Auth Params:) {String} access_token Токен пользователя из сервиса.
             * @apiParam (Social Auth Params:) {String=vkontakte,odnoklassniki} service Название сервиса.
             */
            /**
             * @apiDefine ApiAuthInstruction
             * @apiParam (Api Auth Params:) {String} access_token Токен доступа. Время жизни 30 минут с получения.
             */
            /**
             * @apiDefine FormDataRequest
             * @apiHeader (Content Type:) {application/form-data} format Формат тела запроса.
             */
            /**
             * @apiDefine UrlEncodedRequest
             * @apiHeader (Content Type:) {application/x-www-form-urlencoded} format Формат тела запроса.
             */
            /**
             * @apiDefine Version
             * @apiVersion 0.1.7
             */
            /**
             * @apiGroup Auth
             * @api {post} / Авторизация через токен.
             * @apiUse ApiAuthInstruction
             * @apiVersion 0.1.7
             */
            /**
             * @apiGroup Auth
             * @api {post} login/ Простая аутентификация через жираф.
             * @apiName Login
             * @apiError (Error 401) {String} 401 Ошибка авторизации.
             * @apiErrorExample {json} Error-Response:
             * HTTP/1.1 401 Unauthorized
             * {
             *     "error": "Неверный пароль"
             * }
             * @apiUse SimpleAuthInstruction
             * @apiUse SocialAuthInstruction
             * @apiSuccessExample {json} Success-Response:
            [
                {
                    "id": "451719",
                    "first_name": "Stas",
                    "last_name": "Fomin",
                    "gender": "1",
                    "birthday": "1996-02-02",
                    "last_active": "2015-12-30 11:36:07",
                    "online": "1",
                    "register_date": "2015-12-30 11:36:05",
                    "login_date": "2015-12-30 11:36:07",
                    "relationship_status": null,
                    "mood_id": null,
                    "group": "0",
                    "updated": "2015-12-30 11:36:05",
                    "last_updated": null,
                    "status": "1",
                    "avatarInfo": ""
                },
                {
                    "access_token": "611411cb1e55105646b799672adfe87c",
                    "refresh_token": "a39fcdea6cf69aa42a3dc56c37f9c092",
                    "user_id": "451719",
                    "date": 1451981328,
                    "expire": 1451981388
                }
            ]
             * @apiVersion 0.1.7
             */
            /**
             * @apiGroup Auth
             * @api {post} relogin/ Обновление токена.
             * @apiParam {String} refresh_token Токен для обновления.
             * @apiSuccessExample {json} Success-Response:
            HTTP/1.1 200 OK
            [
                {
                    "id": "451083",
                    "first_name": "Denis",
                    "last_name": "Ivanov",
                    "gender": "1",
                    "birthday": "1980-01-20",
                    "last_active": "2015-12-30 14:10:43",
                    "online": "1",
                    "register_date": "2015-12-11 09:46:26",
                    "login_date": "2015-12-30 14:10:43",
                    "relationship_status": null,
                    "mood_id": null,
                    "group": "0",
                    "updated": "2015-12-11 09:46:23",
                    "last_updated": null,
                    "status": "1",
                    "avatarInfo": ""
                },
                {
                    "access_token": "bba1a206b7e5b920d6acf4d34002e93c",
                    "refresh_token": "bdf6b094c8142503ba985ca952be6417",
                    "user_id": "451083",
                    "date": 1451981745,
                    "expire": 1451981805
                }
            ]
             * @apiVersion 0.1.7
             */
            /**
             * @apiGroup Auth
             * @api {post} logout/ Выход.
             * @apiUse ApiAuthInstruction
             * @apiSuccessExample {json} Success-Response:
            HTTP/1.1 200 OK
            [
                {
                    "access_token": "0c2cd29bfab966dbd7587421a5a1f43f",
                    "refresh_token": "08414dfb75d46142533507c31942c034",
                    "user_id": "451083",
                    "date": 1451485946,
                    "expire": 1451981699
                }
            ]
             * @apiVersion 0.1.7
             */
            'login' => array(
                'class' => 'site\frontend\modules\v1\actions\LoginAction',
            ),
            /**
             * @apiDefine GetInstruction
             * @apiParam (Get Params:) {Number} [page=1] Номер страницы.
             * @apiParam (Get Params:) {Number} [per-page=20] Количество записей на странице.
             * @apiParam (Get Params:) {Number} [id] Получение записи по id. При этом параметры page и per-page игнорируются.
             * @apiParam (Get Params:) {String[]} [expand] Получение связанных записей. Пример: expand=author,comments.
             * @apiParam (Get Params:) {String} [order] Строка с выражением сортировки. Например: order=id desc
             */
            /**
             * @apiGroup Sections
             * @apiDescription Получение списка секций.
             * @api {get} sections/:id Получение секций.
             * @apiUse GetInstruction
             * @apiParam (Relations:) {1xN} clubs Список клубов в этой секции.
             * @apiSuccessExample {json} Success-Response:
             HTTP/1.1 200 OK
             [
                {
                    "id": "1",
                    "title": "Беременность и дети",
                    "color": "64b2e5"
                },
                {
                    "id": "2",
                    "title": "Наш дом",
                    "color": "73c76a"
                },
                {
                    "id": "3",
                    "title": "Красота и здоровье",
                    "color": "f26748"
                },
                {
                    "id": "4",
                    "title": "Муж и жена",
                    "color": "ff76a1"
                },
                {
                    "id": "5",
                    "title": "Интересы и увлечения",
                    "color": "a591cd"
                },
                {
                    "id": "6",
                    "title": "Семейный отдых",
                    "color": "ffd72c"
                }
            ]
             * @apiVersion 0.1.7
             */
            'sections' => array(
                'class' => 'site\frontend\modules\v1\actions\SectionsAction',
            ),
            /**
             * @apiGroup Clubs
             * @apiDescription Получение списка клубов.
             * @api {get} clubs/:id Получение клубов.
             * @apiUse GetInstruction
             * @apiParam (Relations:) {1x1} section Секция, к которой относится этот клуб.
             * @apiParam (Relations:) {1xN} communities Список форумов в этом клубе.
             * @apiParam (Relations:) {NxN} services Сервисы в клубе.
             * @apiParam (Relations:) {1x1} contest Конкурс в этом клубе.
             * @apiSuccessExample {json} Success-Response:
            HTTP/1.1 200 OK
            [
                {
                    "id": "1",
                    "title": "Планирование",
                    "description": "Правильная подготовка к зачатию - залог успешной беременности. Место общения будущих родителей, которые знают, что беременность начинается с планирования.",
                    "section_id": "1",
                    "services_description": "Запланировав рождение малыша, будущие родители так хотят избежать возможных ошибок и промахов. Им в помощь - полезные и актуальные онлайн-сервисы по подсчету регулярности женского цикла, определению пола ребенка и даже интерактивный тест на беременность.",
                    "services_title": "Сервисы для планирующих",
                    "slug": "planning-pregnancy"
                },
                {
                    "id": "2",
                    "title": "Беременность и роды",
                    "description": "Счастливая беременность и легкие роды: делимся опытом, обсуждаем советы профессионалов, настраиваемся на позитив!",
                    "section_id": "1",
                    "services_description": "Каждая женщина мечтает об успешной и легкой беременности. В этом помогут сервисы по определению своего веса в период вынашивания ребенка, а также по измерению толщины плаценты и подсчету схваток. Мы поможем вовремя уйти в декрет и быстро собраться в роддом. Кроме того, вы можете с максимальной достоверностью узнать пол и подобрать красивое имя для вашего ребенка.",
                    "services_title": "Сервисы для беременных",
                    "slug": "pregnancy-and-birth"
                }
            ]
             * @apiVersion 0.1.7
             */
            'clubs' => array(
                'class' => 'site\frontend\modules\v1\actions\ClubsAction',
            ),
            /**
             * @apiGroup Forums
             * @apiDescription Получение списка форумов.
             * @api {get} forums/:id Получение форумов.
             * @apiUse GetInstruction
             * @apiParam (Relations:) {1xN} rubrics Рубрики в этом форуме.
             * @apiParam (Relations:) {1xN} rootRubrics Пока неизвестно.
             * @apiParam (Relations:) {NxN} users Подписанные пользователи.
             * @apiParam (Relations:) {Stat} usersCount Количество подписанных на форум пользователей.
             * @apiParam (Relations:) {1x1} mobileCommunity Пока неизвестно.
             * @apiParam (Relations:) {1x1} club Клуб, в котором находится форум.
             * @apiParam (Relations:) {1x1} contest Конкурс.
             * @apiSuccessExample {json} Success-Response:
            HTTP/1.1 200 OK
            [
                {
                    "id": "1",
                    "title": "Планирование",
                    "short_title": "",
                    "description": null,
                    "pic": "",
                    "position": "1",
                    "css_class": "kids",
                    "mobile_community_id": "1",
                    "club_id": "1"
                },
                {
                    "id": "2",
                    "title": "Беременность",
                    "short_title": "",
                    "description": null,
                    "pic": "",
                    "position": "2",
                    "css_class": "kids",
                    "mobile_community_id": "2",
                    "club_id": "2"
                }
            ]
             * @apiVersion 0.1.7
             */
            'forums' => array(
                'class' => 'site\frontend\modules\v1\actions\ForumsAction',
            ),
            /**
             * @apiGroup Rubrics
             * @apiDescription Получение списка рубрик.
             * @api {get} rubrics/:id Получение рубрик.
             * @apiUse GetInstruction
             * @apiParam (Relations:) {1x1} community Родительский форум для этой рубрики.
             * @apiParam (Relations:) {1x1} user Пока неизвестно.
             * @apiParam (Relations:) {1xN} contests Конкурсы в этой рубрике.
             * @apiParam (Relations:) {Stat} contestsCount Количество конкурсов в этой рубрике.
             * @apiParam (Relations:) {1xN} childs Пока неизвестно.
             * @apiParam (Relations:) {1x1} parent Пока неизвестно.
             * @apiSuccessExample {json} Success-Response:
            HTTP/1.1 200 OK
            [
                {
                    "id": "1",
                    "title": "Планирование беременности",
                    "community_id": "1",
                    "user_id": null,
                    "parent_id": null,
                    "sort": "0",
                    "label_id": null
                },
                {
                    "id": "2",
                    "title": "Планирование повторной беременности",
                    "community_id": "1",
                    "user_id": null,
                    "parent_id": null,
                    "sort": "0",
                    "label_id": null
                }
            ]
             * @apiVersion 0.1.7
             */
            'rubrics' => array(
                'class' => 'site\frontend\modules\v1\actions\RubricsAction',
            ),
            /**
             * @apiGroup Users
             * @apiDescription Получение списка пользователей.
             * @api {get} users/:id Получение пользователей.
             * @apiUse GetInstruction
             * @apiParam (Relations:) {1x1} avatar Пока неизвестно.
             * @apiParam (Relations:) {1xN} babies Дети пользователя.
             * @apiParam (Relations:) {1xN} realBabies Настоящие дети пользователя.
             * @apiParam (Relations:) {1xN} social_services Пока неизвестно.
             * @apiParam (Relations:) {NxN} communities Подписки на форумы.
             * @apiParam (Relations:) {1xN} comments Комментарии пользователя.
             * @apiParam (Relations:) {1xN} menstrualUserCycles Менструальные циклы пользователя.
             * @apiParam (Relations:) {1xN} UserCaches Пока неизвестно.
             * @apiParam (Relations:) {1xN} Messages Сообщения пользователя.
             * @apiParam (Relations:) {1xN} dialogUsers Пока неизвестно.
             * @apiParam (Relations:) {1xN} names Имена?
             * @apiParam (Relations:) {1xN} recipeBookRecipes Рецепты пользователя.
             * @apiParam (Relations:) {1xN} userPointsHistories История очков пользователя.
             * @apiParam (Relations:) {1xN} userSocialServices Пока неизвестно.
             * @apiParam (Relations:) {Stat} commentsCount Количество комментариев.
             * @apiParam (Relations:) {1x1} purpose Пока неизвестно.
             * @apiParam (Relations:) {1xN} albums Альбомы пользователя.
             * @apiParam (Relations:) {1x1} privateAlbum Пока неизвестно.
             * @apiParam (Relations:) {1xN} simpleAlbums Пока неизвестно.
             * @apiParam (Relations:) {NxN} interests Пока неизвестно.
             * @apiParam (Relations:) {1x1} mood Настроение.
             * @apiParam (Relations:) {1x1} partner Партнер.
             * @apiParam (Relations:) {1xN} blog_rubrics Рубрики в блоге пользователя.
             * @apiParam (Relations:) {Stat} communityPostsCount Количество постов на форуме.
             * @apiParam (Relations:) {Stat} communityContestsCount Пока неизвестно.
             * @apiParam (Relations:) {Stat} cookRecipesCount Количество рецептов.
             * @apiParam (Relations:) {Stat} recipeBookRecipesCount Количество рецептов.
             * @apiParam (Relations:) {Stat} albumsCount Количество альбомов.
             * @apiParam (Relations:) {Stat} communitiesCount Пока неизвестно.
             * @apiParam (Relations:) {1xN} userDialogs Диалоги пользователя.
             * @apiParam (Relations:) {1x1} userDialog Пока неизвестно.
             * @apiParam (Relations:) {1xN} blogPosts Посты в блоге.
             * @apiParam (Relations:) {1x1} address Адрес пользователя.
             * @apiParam (Relations:) {1x1} priority Пока неизвестно.
             * @apiParam (Relations:) {Stat} recipes Пока неизвестно.
             * @apiParam (Relations:) {1xN} answers Пока неизвестно.
             * @apiParam (Relations:) {1x1} activeQuestion Пока неизвестно.
             * @apiParam (Relations:) {1xN} photos Пока неизвестно.
             * @apiParam (Relations:) {1x1} mail_subs Пока неизвестно.
             * @apiParam (Relations:) {1x1} score Пока неизвестно.
             * @apiParam (Relations:) {1xN} awards Пока неизвестно.
             * @apiParam (Relations:) {NxN} achievements Ачивки пользователя.
             * @apiParam (Relations:) {1xN} friendLists Пока неизвестно.
             * @apiParam (Relations:) {1x1} subscriber Пока неизвестно.
             * @apiParam (Relations:) {1x1} clubSubscriber Пока неизвестно.
             * @apiParam (Relations:) {1xN} clubSubscriptions Пока неизвестно.
             * @apiParam (Relations:) {Stat} clubSubscriptionsCount Пока неизвестно.
             * @apiParam (Relations:) {1x1} blogPhoto Пока неизвестно.
             * @apiParam (Relations:) {NxN} specializations Пока неизвестно.
             * @apiParam (Relations:) {1xN} communityPosts Посты на форуме.
             * @apiParam (Relations:) {1x1} spamStatus Пока не известно.
             * @apiSuccessExample {json} Success-Response:
             HTTP/1.1 200 OK
            [
                {
                    "id": "123456",
                    "first_name": "Anna",
                    "last_name": "Ivanova",
                    "gender": "0",
                    "birthday": null,
                    "last_active": "2013-04-06 23:28:38",
                    "online": "0",
                    "register_date": "2013-04-06 23:28:21",
                    "login_date": "2013-04-06 23:28:21",
                    "relationship_status": null,
                    "mood_id": null,
                    "group": "0",
                    "updated": "2013-04-06 23:28:21",
                    "last_updated": null,
                    "status": "1",
                    "avatarInfo": ""
                }
            ]
             * @apiVersion 0.1.7
             */
            'users' => array(
                'class' => 'site\frontend\modules\v1\actions\UsersAction',
            ),
            /**
             * @apiGroup Comments
             * @api {get} comments/:id Получение комментариев.
             * @apiUse GetInstruction
             * @apiParam (Get Params:) {Number} [entity_id] Id поста (В таком случае вернутся только корневые комментарии).
             * @apiparam (Get Params:) {Number} [root_id] Id родительского коммента (только корневого), для которого нужно получить комментарии.
             * @apiSuccessExample {json} Success-Response:
            HTTP/1.1 200 OK
            [
                {
                    "id": "123456",
                    "text": "<p>  \tВот это да. Но я бы на такое не решилась! Таким способом хорошо привлекать к себе внимание</p>  ",
                    "updated": 1451466552,
                    "created": 1347705551,
                    "author_id": "15566",
                    "entity": "CommunityContent",
                    "entity_id": "30085",
                    "response_id": null,
                    "quote_id": null,
                    "quote_text": "",
                    "position": "6",
                    "removed": "0",
                    "root_id": "123456",
                    "new_entity_id": "430087"
                }
            ]
             * @apiVersion 0.1.7
             */
            /**
             * @apiGroup Comments
             * @api {post} comments/ Создание комментария.
             * @apiUse ApiAuthInstruction
             * @apiUse SocialAuthInstruction
             * @apiUse FormDataRequest
             * @apiParam (Post Params:) {Number} entity_id Id комментируемой сущности.
             * @apiParam (Post Params:) {String} text Текст коментария.
             * @apiParam (Post Params:) {Number} [response_id] Id комментария, для которого новый комментарий станет ответом.
             * @apiSuccessExample {json} Success-Response:
            HTTP/1.1 200 OK
            [
                {
                    "id": "1187771",
                    "text": "test text asd3",
                    "updated": "2015-12-17 12:05:25",
                    "created": "2015-12-17 12:05:24",
                    "author_id": "241803",
                    "entity": "CommunityContent",
                    "entity_id": "120431",
                    "response_id": null,
                    "quote_id": null,
                    "quote_text": "",
                    "position": "0",
                    "removed": "0",
                    "root_id": "1187771",
                    "new_entity_id": "28"
                }
            ]
             * @apiVersion 0.1.7
             */
            /**
             * @apiGroup Comments
             * @api {put} comments/ Изменение комментария.
             * @apiUse ApiAuthInstruction
             * @apiUse SocialAuthInstruction
             * @apiUse UrlEncodedRequest
             * @apiParam (Put Params:) {Number} id Id комментария.
             * @apiParam (Put Params:) {String} text Текст комментария.
             * @apiSuccessExample {json} Success-Response:
            HTTP/1.1 200 OK
            {
                "id": 1187752,
                "entity": "NewPhotoPost",
                "entityId": 14,
                "authorId": 241796,
                "purifiedHtml": "ssdfsdfger",
                "originHtml": "ssdfsdfger",
                "specialistLabel": null,
                "likesCount": 0,
                "photoId": 0,
                "entityUrl": false,
                "responseId": 0,
                "rootId": 1187752,
                "dtimeCreate": 1449669117
            }
             * @apiVersion 0.1.7
             */
            /**
             * @apiGroup Comments
             * @api {delete} comments/ Удаление комментария.
             * @apiUse ApiAuthInstruction
             * @apiUse SocialAuthInstruction
             * @apiParam (Delete Params:) {Number} id Id комментария.
             * @apiVersion 0.1.7
             */
            'comments' => array(
                'class' => 'site\frontend\modules\v1\actions\CommentsAction',
            ),
            /**
             * @apiGroup Posts
             * @api {get} posts/:id Получение поста.
             * @apiUse GetInstruction
             * @apiParam (Relations:) {1x1} author Автор поста.
             * @apiParam (Relations:) {1x1} comments Комментарии к посту.
             * @apiParam (Relations:) {1x1} comments_count Количество комментариев к посту.
             * @apiSuccessExample {json} Success-Response:
            [
                {
                    "id": "1",
                    "url": "http://www.happy-giraffe.ru/user/241791/blog/post120396/",
                    "authorId": "241791",
                    "title": "test",
                    "html": "<p>test</p>",
                    "labels": "Блог|Рубрика: Обо всём",
                    "dtimeCreate": "1444035590",
                    "dtimeUpdate": "1444041705",
                    "dtimePublication": "1444035590",
                    "originService": "oldBlog",
                    "originEntityId": "120396",
                    "originManageInfo": "{\"link\":{\"url\":\"\/blogs\/edit\/post\",\"get\":{\"id\":\"120396\"}},\"params\":false}",
                    "isDraft": "0",
                    "uniqueIndex": "100",
                    "isNoindex": "0",
                    "isNofollow": "0",
                    "isAutoMeta": "1",
                    "isAutoSocial": "1",
                    "isRemoved": "0",
                    "isAdult": "0",
                    "meta": "{\"title\":\"test\",\"keywords\":null,\"description\":\"test\"}",
                    "social": "{\"title\":null,\"imageUrl\":null,\"description\":\"test\"}",
                    "template": "{\"layout\":\"newBlogPost\",\"data\":{\"type\":\"post\"}}",
                    "views": "0"
                },
                {
                    "id": "2",
                    "url": "http://www.happy-giraffe.ru/user/241791/blog/post120397/",
                    "authorId": "241791",
                    "title": "asdasd",
                    "html": "<p>asdasdasdasd</p>",
                    "labels": "Блог|Рубрика: Обо всём",
                    "dtimeCreate": "1444041758",
                    "dtimeUpdate": "1444041921",
                    "dtimePublication": "1444041758",
                    "originService": "oldBlog",
                    "originEntityId": "120397",
                    "originManageInfo": "{\"link\":{\"url\":\"\/blogs\/edit\/post\",\"get\":{\"id\":\"120397\"}},\"params\":false}",
                    "isDraft": "0",
                    "uniqueIndex": "100",
                    "isNoindex": "0",
                    "isNofollow": "0",
                    "isAutoMeta": "1",
                    "isAutoSocial": "1",
                    "isRemoved": "0",
                    "isAdult": "0",
                    "meta": "{\"title\":\"asdasd\",\"keywords\":null,\"description\":\"asdasdasdasd\"}",
                    "social": "{\"title\":null,\"imageUrl\":null,\"description\":\"asdasdasdasd\"}",
                    "template": "{\"layout\":\"newBlogPost\",\"data\":{\"type\":\"post\"}}",
                    "views": "0"
                }
            ]
             * @apiVersion 0.1.7
             */
            /**
             * @apiGroup Posts
             * @api {post} posts/ Создание поста.
             * @apiUse ApiAuthInstruction
             * @apiUse SocialAuthInstruction
             * @apiUse FormDataRequest
             * @apiParam (Post Params:) {Number=1,2,3,4} type_id Id типа поста в зависимости от контента (пост, фотопост, видеопост, статус).
             * @apiParam (Post Params:) {Number} rubric_id Id рубрики, в которой будет находиться пост. (Не задавать это тпараметр дял постов в блоге).
             * @apiParam (Post Params:) {String} text Текст поста.
             * @apiParam (Post Params:) {String} title Заголовок поста.
             * @apiParam (Post Params:) {String="forum","blog"} type Тип поста в зависимости от расположения (форум или блог).
             * @apiParam (Post Params:) {Object[]} [photos] Коллекция фотографий для фотопостов.
             * @apiParam (Post Params:) {String} [link] Ссылка на видео для видеопостов.
             * @apiVersion 0.1.7
             */
            /**
             * @apiGroup Posts
             * @api {put} posts/ Изменение поста.
             * @apiUse ApiAuthInstruction
             * @apiUse SocialAuthInstruction
             * @apiUse UrlEncodedRequest
             * @apiParam (Put Params:) {Number} id Id изменяемого поста.
             * @apiParam (Put Params:) {String} title Заголовок поста.
             * @apiParam (Put Params:) {String} text Текст поста.
             * @apiParam (Put Params:) {String="forum","blog"} type Тип поста в зависимости от расположения.
             * @apiParam (Put Params:) {Number} rubric_id Id рубрики.
             * @apiParam (Put Params:) {Object[]} [photos] Коллекция фотографий в фотопосте.
             * @apiParam (Put Params:) {String} [link] Ссылка на видео для видеопостов.
             * @apiVersion 0.1.7
             */
            /**
             * @apiGroup Posts
             * @api {delete} posts/ Удаление поста.
             * @apiUse ApiAuthInstruction
             * @apiUse SocialAuthInstruction
             * @apiParam (Delete Params:) {Number} id Id удаляемого поста.
             * @apiParam (Delete Params:) {String="forum","blog"} type Тип поста в зависимости от расположения.
             * @apiVersion 0.1.7
             */
            'posts' => array(
                'class' => 'site\frontend\modules\v1\actions\PostsAction',
            ),
            /**
             * @apiGroup Onair
             * @api {get} onair/ Получение прямого эфира.
             * @apiUse GetInstruction
             * @apiParam (Relations:) {1x1} type Тип активности.
             * @apiParam (Relations:) {1x1} user Автор активности.
             * @apiSuccessExample {json} Success-Response:
            HTTP/1.1 200 OK
            [
                {
                    "id": "441",
                    "userId": "241803",
                    "typeId": "post",
                    "dtimeCreate": "1449750727",
                    "data": "{\"title\":\"Post From Api 2\",\"url\":\"http:\/\/www.happy-giraffe.ru\/community\/2\/forum\/post\/120788\/\",\"text\":\"<p>Post From Api Text 2<\/p>\"}",
                    "hash": "7256531e22bedcec0a4f2b73e394c8a4"
                },
                {
                    "id": "440",
                    "userId": "241803",
                    "typeId": "post",
                    "dtimeCreate": "1449670391",
                    "data": "{\"title\":\"Post From Api 2\",\"url\":\"http:\/\/www.happy-giraffe.ru\/community\/2\/forum\/post\/120787\/\",\"text\":\"<p>Post From Api Text 2<\/p>\"}",
                    "hash": "73e09b287615622472ae278607a3dfe6"
                }
            ]
             * @apiVersion 0.1.7
             */
            'onair' => array(
                'class' => 'site\frontend\modules\v1\actions\OnairAction',
            ),
            /**
             * @apiGroup PostContent
             * @apiIgnore
             * @api {get} post-content/ Получение контента поста.
             * @apiUse GetInstruction
             * @apiParam (Relations:) {NxN} labelModels Пока неизвестно.
             * @apiParam (Relations:) {1xN} tagModels Пока неизвестно.
             * @apiParam (Relations:) {1x1} author Автор поста.
             * @apiSuccessExample {json} Success-Response:
            HTTP/1.1 200 OK
            [
                {
                    "id": "1",
                    "url": "http://www.happy-giraffe.ru/user/241791/blog/post120396/",
                    "authorId": "241791",
                    "title": "test",
                    "text": "test",
                    "html": "<p>test</p>",
                    "preview": "<p>test</p>",
                    "labels": "Блог|Рубрика: Обо всём",
                    "dtimeCreate": "1444035590",
                    "dtimeUpdate": "1444041705",
                    "dtimePublication": "1444035590",
                    "originService": "oldBlog",
                    "originEntity": "CommunityContent",
                    "originEntityId": "120396",
                    "originManageInfo": "{\"link\":{\"url\":\"\/blogs\/edit\/post\",\"get\":{\"id\":\"120396\"}},\"params\":false}",
                    "isDraft": "0",
                    "uniqueIndex": "100",
                    "isNoindex": "0",
                    "isNofollow": "0",
                    "isAutoMeta": "1",
                    "isAutoSocial": "1",
                    "isRemoved": "0",
                    "isAdult": "0",
                    "meta": "{\"title\":\"test\",\"keywords\":null,\"description\":\"test\"}",
                    "social": "{\"title\":null,\"imageUrl\":null,\"description\":\"test\"}",
                    "template": "{\"layout\":\"newBlogPost\",\"data\":{\"type\":\"post\"}}",
                    "views": "0"
                },
                {
                    "id": "2",
                    "url": "http://www.happy-giraffe.ru/user/241791/blog/post120397/",
                    "authorId": "241791",
                    "title": "asdasd",
                    "text": "asdasdasdasd",
                    "html": "<p>asdasdasdasd</p>",
                    "preview": "<p>asdasdasdasd</p>",
                    "labels": "Блог|Рубрика: Обо всём",
                    "dtimeCreate": "1444041758",
                    "dtimeUpdate": "1444041921",
                    "dtimePublication": "1444041758",
                    "originService": "oldBlog",
                    "originEntity": "CommunityContent",
                    "originEntityId": "120397",
                    "originManageInfo": "{\"link\":{\"url\":\"\/blogs\/edit\/post\",\"get\":{\"id\":\"120397\"}},\"params\":false}",
                    "isDraft": "0",
                    "uniqueIndex": "100",
                    "isNoindex": "0",
                    "isNofollow": "0",
                    "isAutoMeta": "1",
                    "isAutoSocial": "1",
                    "isRemoved": "0",
                    "isAdult": "0",
                    "meta": "{\"title\":\"asdasd\",\"keywords\":null,\"description\":\"asdasdasdasd\"}",
                    "social": "{\"title\":null,\"imageUrl\":null,\"description\":\"asdasdasdasd\"}",
                    "template": "{\"layout\":\"newBlogPost\",\"data\":{\"type\":\"post\"}}",
                    "views": "0"
                }
            ]
             * @apiVersion 0.1.7
             */
            /*'postContent' => array(
                'class' => 'site\frontend\modules\v1\actions\PostContentAction',
            ),*/
            /**
             * @apiGroup PostLabel
             * @apiIgnore
             * @api {get} post-label/ Получение меток постов.
             * @apiUse GetInstruction
             * @apiParam (Relations:) {NxN} postContents Пока неизвестно.
             * @apiSuccessExample {json} Success-Response:
            HTTP/1.1 200 OK
            [
                {
                    "id": "1",
                    "text": "Блог"
                },
                {
                    "id": "2",
                    "text": "Рубрика: Обо всём"
                }
            ]
             * @apiVersion 0.1.7
             */
            /*'postLabel' => array(
                'class' => 'site\frontend\modules\v1\actions\PostLabelAction',
            ),*/
            /**
             * @apiGroup PostTag
             * @apiIgnore
             * @api {get} post-tag/ Получение тегов постов.
             * @apiUse GetInstruction
             * @apiSuccessExample {json} Success-Response:
            HTTP/1.1 200 OK
            [
                {
                    "contentId": "1",
                    "labelId": "1"
                },
                {
                    "contentId": "1",
                    "labelId": "2"
                }
            ]
             * @apiVersion 0.1.7
             */
            /*'postTag' => array(
                'class' => 'site\frontend\modules\v1\actions\PostTagAction',
            ),*/
            /**
             * @apiGroup PostComments
             * @apiIgnore
             * @api {get} post-comments/ Получение комментов в посте.
             * @apiUse GetInstruction
             * @apiParam (Get Params:) {String} service Сервис.
             * @apiParam (Get Params:) {Number} entity_id Id модели.
             * @apiSuccessExample {json} Success-Response:
            HTTP/1.1 200 OK
            [
                {
                    "id": "1187738",
                    "text": "<p>test</p>",
                    "updated": "2015-12-07 17:55:35",
                    "created": "2015-12-07 17:55:35",
                    "author_id": "241803",
                    "entity": "CommunityContent",
                    "entity_id": "120782",
                    "response_id": null,
                    "quote_id": null,
                    "quote_text": "",
                    "position": "0",
                    "removed": "0",
                    "root_id": "1187738"
                },
                {
                    "id": "1187739",
                    "text": "<p>test2</p>",
                    "updated": "2015-12-08 17:16:42",
                    "created": "2015-12-08 17:16:42",
                    "author_id": "241803",
                    "entity": "CommunityContent",
                    "entity_id": "120782",
                    "response_id": "1187738",
                    "quote_id": null,
                    "quote_text": "",
                    "position": "0",
                    "removed": "0",
                    "root_id": "1187738"
                }
            ]
             * @apiVersion 0.1.7
             */
            /*'postComments' => array(
                'class' => 'site\frontend\modules\v1\actions\PostCommentsAction',
            ),*/
            /**
             * @apiGroup Photo
             * @api {post} photo/ Загрузка фотографии.
             * @apiUse ApiAuthInstruction
             * @apiUse SocialAuthInstruction
             * @apiParam (Post Params:) {File} photo Загружаемое изображение.
             * @apiSuccessExample {json} Success-Response:
            HTTP/1.1 200 OK
            [
                {
                    "removed": 0,
                    "hidden": 1,
                    "rate": "0",
                    "views": "0",
                    "author_id": "241803",
                    "fs_name": "16cf3dd937c5186da3c4e14f7f3cfa51.png",
                    "file_name": "screenshot_15-09-29_16-42-48.png",
                    "album_id": "144482",
                    "width": 572,
                    "height": 114,
                    "id": "689688",
                    "title": null,
                    "html": "<img src=\"http://img.giraffe.code-geek.ru/v2/thumbs/e26e4ffdce15f4bc6711c767ffa68dac/0d/71/c921f3eff616c298aa60e6d5aea1.png\" class=\"content-img\">",
                    "comment_html": "<a class=\"comments-gray_cont-img-w\" onclick=\"PhotoCollectionViewWidget.open('AttachPhotoCollection', { entityName : 'Comment', entityId : '' }, '689688')\"><img width=\"395\" height=\"78\" src=\"http://img.giraffe.code-geek.ru/thumbs/395x400/241803/16cf3dd937c5186da3c4e14f7f3cfa51.png\" alt=\"\" /></a>",
                    "url": "http://img.giraffe.code-geek.ru/thumbs/480x250/241803/16cf3dd937c5186da3c4e14f7f3cfa51.png",
                    "new_photo_id": "186"
                }
            ]
             * @apiVersion 0.1.7
             */
            'photo' => array(
                'class' => 'site\frontend\modules\v1\actions\PhotoAction',
            ),
            /***/
            'relogin' => array(
                'class' => 'site\frontend\modules\v1\actions\ReLoginAction',
            ),
            'logout' => array(
                'class' => 'site\frontend\modules\v1\actions\LogoutAction',
            ),
            /**
             * @apiGroup Auth
             * @api {post} check-token/ Проверка токена.
             * @apiParam (Post Params:) access_token Токен доступа.
             * @apiVersion 0.1.7
             */
            'checkToken' => array(
                'class' => 'site\frontend\modules\v1\actions\CheckTokenAction',
            ),
            /**
             * @apiGroup Ideas
             * @api {get} ideas/:id Получение идей.
             * @apiUse ApiAuthInstruction
             * @apiUse SocialAuthInstruction
             * @apiUse GetInstruction
             * @apiParam (Relations: ) {1x1} collection Коллекция фотографий. Специально для этого маршрута вместе с коллекцией фотографий возвращаются attaches и photos одним запросом.
             * @apiParam (Relations: ) {1x1} author Автор идеи.
             * @apiSuccessExample {json} Success-Response:
            [
                {
                    "id": "41",
                    "title": "Idea From API 35",
                    "collectionId": "5760877",
                    "authorId": "451719",
                    "isDraft": "0",
                    "isRemoved": "0",
                    "dtimeCreate": "1453192238",
                    "labels": "",
                    "forumId": null,
                    "collection": {
                    "id": "5760877",
                    "entity": null,
                    "entity_id": null,
                    "key": "",
                    "cover_id": "5133264",
                    "created": "2016-01-12 17:54:56",
                    "updated": "2016-01-12 17:54:57",
                    "attaches": [
                        {
                            "id": "5133262",
                            "photo_id": "3325090",
                            "position": "0",
                            "created": 1452610497,
                            "updated": 1452610497,
                            "removed": "0",
                            "photo": {
                                "id": "3325090",
                                "title": "1111",
                                "description": "1111",
                                "width": "18",
                                "height": "18",
                                "original_name": "18x18.png",
                                "fs_name": "6b/0f/f6a8f3c54b6b71eef3ad5ab169af.png",
                                "created": 1452610433,
                                "updated": 1452610443,
                                "author_id": "451719"
                            }
                        },
                        {
                            "id": "5133263",
                            "photo_id": "3325091",
                            "position": "1",
                            "created": 1452610497,
                            "updated": 1452610497,
                            "removed": "0",
                            "photo": {
                                "id": "3325091",
                                "title": "222",
                                "description": "222",
                                "width": "50",
                                "height": "50",
                                "original_name": "50x50.png",
                                "fs_name": "30/67/dbd6e8dbc26f0e3f498325140bea.png",
                                "created": 1452610434,
                                "updated": 1452610449,
                                "author_id": "451719"
                            }
                        },
                    {
                        "id": "5133264",
                        "photo_id": "3325092",
                        "position": "2",
                        "created": 1452610497,
                        "updated": 1452610497,
                        "removed": "0",
                        "photo": {
                            "id": "3325092",
                            "title": "333",
                            "description": "333",
                            "width": "128",
                            "height": "128",
                            "original_name": "128x128.png",
                            "fs_name": "6d/17/4bbcf01440e68bb48aa54748cc00.png",
                            "created": 1452610436,
                            "updated": 1452610453,
                            "author_id": "451719"
                        }
                        }
                    ]
                    }
                }
            ]
             * @apiVersion 0.1.7
             */
            /**
             * @apiGroup Ideas
             * @api {post} ideas/ Создание идеи.
             * @apiUse ApiAuthInstruction
             * @apiUse SocialAuthInstruction
             * @apiUse FormDataRequest
             * @apiParam (Post Params:) {Number} collectionId Id коллекции фотографий.
             * @apiParam (Post Params:) {String} title Заголовок идеи.
             * @apiParam (Post Params:) {Number} club Id клуба.
             * @apiParam (Post Params:) {Array} forums Айдишники форумов через запятую (без пробелов).
             * @apiParam (Post Params:) {Array} rubrics Айдишники рубрик чяерез запятую (без пробелов).
             * @apiVersion 0.1.7
             */
            /**
             * @apiGroup Ideas
             * @api {put} ideas/ Изменение идеи.
             * @apiParam (Put Params:) {Number} id Id идеи.
             * @apiParam (Put Params:) {Number} collectionId Id коллекции фотографий.
             * @apiParam (Put Params:) {String} title Заголовок идеи.
             * @apiVersion 0.1.7
             */
            /**
             * @apiGroup Ideas
             * @api {delete} ideas/ Удаление идеи.
             * @apiParam (Delete Params:) {Number} id Id идеи.
             * @apiParam (Delete Params:) {String=delete,restore} action Действие.
             * @apiVersion 0.1.7
             */
            'ideas' => array(
                'class' => 'site\frontend\modules\som\modules\idea\actions\IdeasAction',
            ),
        );
    }
    #endregion

    #region Else
    private function isBehaviorExists($name, $behaviors)
    {
        foreach ($behaviors as $key => $value) {
            if ($key == $name) {
                return true;
            }
        }

        return false;
    }

    private function detach($name, $model)
    {
        if ($this->isBehaviorExists($name, $model->behaviors())) {
            $model->detachBehavior($name);
        }
    }
    #endregion
}