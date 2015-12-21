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
             * @apiDefine FormDataRequest
             * @apiHeader (Content Type:) {application/form-data} format Формат тела запроса.
             */
            /**
             * @apiDefine UrlEncodedRequest
             * @apiHeader (Content Type:) {application/x-www-form-urlencoded} format Формат тела запроса.
             */
            /**
             * @apiGroup Auth
             * @api {post} login/ Простая авторизация через happy-giraffe
             * @apiName Login
             * @apiDescription Авторизует пользователя в приложении посредством логина и пароля.
             * Возвращает информацию об авторизованном пользователе или ошибку.
             * @apiError (Error 401) {String} 401 Ошибка авторизации.
             * @apiErrorExample {json} Error-Response:
             * HTTP/1.1 401 Unauthorized
             * {
             *     "error": "Неверный пароль"
             * }
             * @apiUse SimpleAuthInstruction
             * @apiSuccessExample {json} Success-Response:
             HTTP/1.1 200 OK
            [
                {
                    "id": "241803",
                    "first_name": "Stas",
                    "last_name": "Fomin",
                    "gender": "1",
                    "birthday": "1996-04-02",
                    "last_active": "2015-11-12 15:30:13",
                    "online": "1",
                    "deleted": "0",
                    "blocked": "0",
                    "register_date": "2015-11-12 15:30:08",
                    "login_date": "2015-11-12 15:30:13",
                    "relationship_status": null,
                    "mood_id": null,
                    "group": "1",
                    "updated": "2015-11-12 15:30:08",
                    "last_updated": null,
                    "status": "1",
                    "avatarInfo": ""
                }
            ]
             * @apiVersion 0.0.1
             */
            'login' => array(
                'class' => 'site\frontend\modules\v1\actions\LoginAction',
            ),
            /**
             * @apiDefine GetInstruction
             * @apiParam (Get Params:) {Number} [page=1] Номер страницы.
             * @apiParam (Get Params:) {Number} [per-page=20] Количество записей на странице.
             * @apiParam (Get Params:) {Number} [id] Получение записи по id. При этом параметры page и size игнорируются.
             * @apiParam (Get Params:) {String[]} [expand] Получение связанных записей. Пример: with=author,comments.
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
             * @apiVersion 0.0.1
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
             * @apiVersion 0.0.1
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
             * @apiVersion 0.0.1
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
             * @apiVersion 0.0.1
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
                    "id": "1",
                    "first_name": "Веселый жираф",
                    "last_name": "",
                    "gender": "1",
                    "birthday": null,
                    "last_active": "2012-11-20 16:15:29",
                    "online": "0",
                    "deleted": "0",
                    "blocked": "0",
                    "register_date": "2012-01-01 00:00:00",
                    "login_date": "2013-09-10 17:27:07",
                    "relationship_status": null,
                    "mood_id": null,
                    "group": "3",
                    "updated": "2013-09-10 17:27:07",
                    "last_updated": null,
                    "status": "1",
                    "avatarInfo": ""
                },
                {
                    "id": "5",
                    "first_name": "Смит",
                    "last_name": "Рус",
                    "gender": "1",
                    "birthday": "1989-09-26",
                    "last_active": "2013-03-12 01:22:29",
                    "online": "0",
                    "deleted": "0",
                    "blocked": "0",
                    "register_date": "2011-12-27 18:11:33",
                    "login_date": "2013-03-12 01:21:34",
                    "relationship_status": "2",
                    "mood_id": "18",
                    "group": null,
                    "updated": "2013-08-20 14:39:06",
                    "last_updated": null,
                    "status": "1",
                    "avatarInfo": ""
                }
            ]
             * @apiVersion 0.0.1
             */
            'users' => array(
                'class' => 'site\frontend\modules\v1\actions\UsersAction',
            ),
            /**
             * @apiGroup Comments
             * @api {get} comments/:id Получение комментариев.
             * @apiUse GetInstruction
             * @apiParam (Get Params:) {Number} [entity_id] Id поста.
             * @apiSuccessExample {json} Success-Response:
            HTTP/1.1 200 OK
            [
                {
                    "id": "1",
                    "text": "changed text",
                    "updated": "2015-10-23 11:42:37",
                    "created": "2011-11-04 12:57:49",
                    "author_id": "19",
                    "entity": "CommunityContent",
                    "entity_id": "26",
                    "response_id": null,
                    "quote_id": null,
                    "quote_text": "",
                    "position": "1",
                    "removed": "0",
                    "root_id": "1"
                },
                {
                    "id": "2",
                    "text": "\r\n<p>Вот честно – мне тяжело понять тех, кто с рождения пытается устанавливать режим для ребенка, чтобы быть «свободнее». А надо ли быть свободнее? Я стала мамой! Это огромное счастье! Кормление – это повод быть рядом с малышом, наслаждаться единением с ним. И я наслаждалась. Если ребенку спокойно рядом с мамой – зачем засекать эти 10 минут и потом перекладывать ребенка в кровать и заниматься своими делами. Самое главное дело для молодой мамы – ребенок.</p>",
                    "updated": "2014-08-11 13:59:06",
                    "created": "2011-11-04 13:17:55",
                    "author_id": "32",
                    "entity": "CommunityContent",
                    "entity_id": "26",
                    "response_id": null,
                    "quote_id": null,
                    "quote_text": "",
                    "position": "2",
                    "removed": "0",
                    "root_id": "2"
                }
            ]
             * @apiVersion 0.0.1
             */
            /**
             * @apiGroup Comments
             * @api {post} comments/ Создание комментария.
             * @apiUse SimpleAuthInstruction
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
             * @apiVersion 0.0.1
             */
            /**
             * @apiGroup Comments
             * @api {put} comments/ Изменение комментария.
             * @apiUse SimpleAuthInstruction
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
             * @apiVersion 0.0.1
             */
            /**
             * @apiGroup Comments
             * @api {delete} comments/ Удаление комментария.
             * @apiUse SimpleAuthInstruction
             * @apiParam (Delete Params:) {Number} id Id комментария.
             * @apiVersion 0.0.1
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
             * @apiversion 0.0.1
             */
            /**
             * @apiGroup Posts
             * @api {post} posts/ Создание поста.
             * @apiUse SimpleAuthInstruction
             * @apiUse FormDataRequest
             * @apiParam (Post Params:) {Number=1,2,3,4} type_id Id типа поста в зависимости от контента (пост, фотопост, видеопост, статус).
             * @apiParam (Post Params:) {Number} rubric_id Id рубрики, в которой будет находиться пост.
             * @apiParam (Post Params:) {String} text Текст поста.
             * @apiParam (Post Params:) {String} title Заголовок поста.
             * @apiParam (Post Params:) {String="forum","blog"} type Тип поста в зависимости от расположения (форум или блог).
             * @apiParam (Post Params:) {Object[]} [photos] Коллекция фотографий для фотопостов.
             * @apiParam (Post Params:) {String} [link] Ссылка на видео для видеопостов.
             * @apiVersion 0.0.1
             */
            /**
             * @apiGroup Posts
             * @api {put} posts/ Изменение поста.
             * @apiUse SimpleAuthInstruction
             * @apiUse UrlEncodedRequest
             * @apiParam (Put Params:) {Number} id Id изменяемого поста.
             * @apiParam (Put Params:) {String} title Заголовок поста.
             * @apiParam (Put Params:) {String} text Текст поста.
             * @apiParam (Put Params:) {String="forum","blog"} type Тип поста в зависимости от расположения.
             * @apiParam (Put Params:) {Number} rubric_id Id рубрики.
             * @apiParam (Put Params:) {Object[]} [photos] Коллекция фотографий в фотопосте.
             * @apiParam (Put Params:) {String} [link] Ссылка на видео для видеопостов.
             * @apiVersion 0.0.1
             */
            /**
             * @apiGroup Posts
             * @api {delete} posts/ Удаление поста.
             * @apiUse SimpleAuthInstruction
             * @apiParam (Delete Params:) {Number} id Id удаляемого поста.
             * @apiParam (Delete Params:) {String="forum","blog"} type Тип поста в зависимости от расположения.
             * @apiVersion 0.0.1
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
             * @apiVersion 0.0.1
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
             * @apiVersion 0.0.1
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
             * @apiVersion 0.0.1
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
             * @apiVersion 0.0.1
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
             * @apiVersion 0.0.1
             */
            /*'postComments' => array(
                'class' => 'site\frontend\modules\v1\actions\PostCommentsAction',
            ),*/
            'photo' => array(
                'class' => 'site\frontend\modules\v1\actions\PhotoAction',
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