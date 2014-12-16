define(['jquery', 'knockout', 'models/UserController', 'models/User', 'models/Comment', 'user-config', 'knockout.mapping'], function ($, ko, UserControl, User, Comment, userConfig) {

    var CommentsController = {

        /**
         * Размер аватары пользователей для комментариев
         * @type {Number}
         */
        commentAvatarSize: 40,

        mappingIgnore: ["editorConfig"],

        /**
         * [getListData Массив собирающий параметры для запроса к API]
         * @param  {[type]} entitySub   Entity из параметров компонента
         * @param  {string} entityIdSub EntityId из параметров компонента id сущности
         * @param  {string} listType    тип получения данных list или tree
         * @return {object}             Объект с параметрами для запроса
         */
        getListData: function getListData(entitySub, entityIdSub, listType) {
            return {
                entity: entitySub,
                entityId: entityIdSub,
                listType: listType,
                rootCount: false,
                dtimeFrom: 0
            };
        },

        /**
         * создания пака из массива с id пользователей
         * @param  {Array} array Массив с id пользователей
         * @return {Array}       Массив с объектами типа { id: number }
         */
        createPackList: function createPackList(array) {
            if (array.length > 0) {
                var i;
                /**
                 * Добавляем автора к пользователям
                 */
                array = UserControl.checkForMe(array);

                for (i = 0; i < array.length; i++) {
                    array[i] = { id: array[i] };
                }

                return array;
            }
            return false;
        },

        /**
         * Цвета для ленты комментариев
         * @type {Array}
         */
        commentsColors: ['lilac', 'yellow', 'red', 'blue', 'green'],

        /**
         * Получить следующий цвет для комментариев
         * @param  {string} color текущий цвет
         * @return {string}       следующий цвет
         */
        nextColor: function nextColor(color) {
            return this.commentsColors[($.inArray(color, this.commentsColors) + 1) % this.commentsColors.length];
        },

        /**
         * Получить предыдущий цвет для комментариев
         * @param  {string} color текущий цвет
         * @return {string}       следующий цвет
         */
        prevColor: function prevColor(color) {
            return this.commentsColors[($.inArray(color, this.commentsColors) - 1 + this.commentsColors.length) % this.commentsColors.length];
        },

        /**
         * Получить первый цвет для комментариев
         * @param  {[type]} commentsData [description]
         * @return {[type]}              [description]
         */
        getFirstColor: function getFirstColor(commentsData) {
            if (commentsData === undefined) {
                return this.commentsColors[0];
            }
            return commentsData[0].color();
        },

        /**
         * [checkChildrenNotice собирает информацию о наличии детей]
         * @param {int} counter счетчик
         * @param {Array} array   Массив комментариев
         */
        checkChildrenNotice: function checkChildrenNotice(counter, array) {
            if (counter + 1 !== array.length && array[counter + 1].rootId === array[counter].id) {
                return true;
            }
            return false;
        },

        /**
         * Мердж данных юзеров и комментариев, все ответы в отдельное свойство и массив рутового комментария, цвет рутового комментария
         * @param  {Array} dataUser     Данные о юзерах
         * @param  {Array} dataComments Данные о комментариях
         * @return {Array}              Смердженный массив комментариев
         */
        allDataReceived: function allDataReceived(dataUser, dataComments) {
            var commentsArray = [],
                color,
                dataCounter,
                userKey,
                newArrayCounter,
                response,
                responseToComment,
                user;

            for (dataCounter = 0; dataCounter < dataComments.length; dataCounter++) {
                userKey = UserControl.isUserInPack(dataComments[dataCounter].authorId, dataUser);

                if (userKey !== false) {
                    dataComments[dataCounter].user = {};
                    user = Object.create(User);
                    dataComments[dataCounter].user = user.init(dataUser[userKey].data);
                }

                if (dataComments[dataCounter].responseId === 0) {
                    dataComments[dataCounter].answers = [];
                    newArrayCounter = commentsArray.push(dataComments[dataCounter]);
                    if (newArrayCounter === 1) {
                        color = this.commentsColors[0];
                    } else {
                        color = this.nextColor(color);
                    }
                    commentsArray[newArrayCounter - 1].color = color;
                } else {
                    response = dataComments[dataCounter];
                    responseToComment = this.findById(response.responseId, dataComments);

                    if (responseToComment) {
                        response.answerTo.fullName = responseToComment.user.fullName;
                        response.answerTo.profileUrl = responseToComment.user.profileUrl;
                        responseToComment.hasAnswers = true;
                    }

                    commentsArray[newArrayCounter - 1].answers.push(response);

                }

            }

            return commentsArray;
        },

        /**
         * [parseData Выполняем необходимые операции на полученных данных из API]
         * @param  {object} parsingData raw объект
         * @return {object}              объект данных с комментариями и пользователями
         */
        parseData: function parseData(parsingData) {
            if (parsingData.success === true) {
                var notReadyData = parsingData.data.list,
                    userPack = { pack: [], avatarSize: this.commentAvatarSize},
                    rootCount,
                    comment;

                for (rootCount = 0; rootCount < notReadyData.length; rootCount++) {

                    comment = Object.create(Comment);

                    notReadyData[rootCount] = comment.init(notReadyData[rootCount]);

                    if ($.inArray(notReadyData[rootCount].authorId, userPack.pack) === -1) {
                        userPack.pack.push(notReadyData[rootCount].authorId);
                    }
                }

                userPack.pack = this.createPackList(userPack.pack);

                if (userPack.pack === false) {
                    userPack.pack = [];
                    userPack.pack.push({id: userConfig.userId});
                }

                return {
                    commentsData: notReadyData,
                    userPack: userPack
                };
            }
            return false;
        },

        /**
         * Создание отдельного комментария
         * @param  {string} entity
         * @param  {int} entityId
         * @param  {string} text
         * @param  {id} responseId
         * @return {object}
         */
        createComment: function createComment(entity, entityId, text, responseId) {
            if (responseId === undefined) {

                return {
                    entity: entity,
                    entityId: entityId,
                    text: text
                };
            }

            return {
                entity: entity,
                entityId: entityId,
                text: text,
                responseId: responseId
            };
        },


        /**
         * Проверка массива на присутстивие элемента с определенным свойством
         * @param  {object}   comment    Объект комментария
         * @param  {Array} parsedData Массив с комментариями
         * @return {Object}                      Объект комментария
         */
        removedStatus: function removedStatus(comment, parsedData) {

            var commentObj,
                i;

            if (parsedData.length > 0) {
                for (i = 0; i < parsedData.length; i++) {
                    if (comment.id === parsedData[i].id()) {
                        commentObj = i;
                    }
                }

            }
            return commentObj;
        },

        /**
         * Находит элемент в массиве ответов
         * @param comment
         * @param answersArray
         * @returns {*}
         */
        findInAnswers: function findInAnswers(comment, answersArray) {
            var commentObj,
                id = comment.id,
                i;

            if (answersArray.length > 0) {
                for (i = 0; i < answersArray.length; i++) {
                    if (id === answersArray[i].id()) {
                        commentObj = i;
                    }
                }

            }
            return commentObj;
        },

        /**
         * Проверка на то, ответ это или новый корневой комментарий
         * @param comment
         * @param parsedData
         * @returns {*}
         */
        findIfAnswer: function findIfAnswer(comment, parsedData) {
            var commentObj,
                id = comment.responseId,
                i;

            if (comment.rootId !== 0) {
                id = comment.rootId;
            }
            if (parsedData.length > 0) {
                for (i = 0; i < parsedData.length; i++) {
                    if (id === parsedData[i].id()) {
                        commentObj = i;
                    }
                }

            }
            return commentObj;

        },

        /**
         * Поиск по id
         * @param responseId
         * @param parsedData
         * @returns {*}
         */
        findById: function findById(responseId, parsedData) {
            if (parsedData.length > 0) {
                var i,
                    k;
                for (i = 0; i < parsedData.length; i++) {
                    if(responseId === parsedData[i].id) {
                        return parsedData[i];
                    }
                    if (parsedData[i].answers.length > 0) {
                        for (k = 0; k < parsedData[i].answers.length; k++) {
                            if (responseId === parsedData[i].answers[k].id) {
                                return parsedData[i].answers[k];
                            }
                        }
                    }
                }
            }
            return false;
        },

        /**
         * Поиск по observableId
         * @param responseId
         * @param parsedData
         * @param makeNotDeleteable
         * @returns {*}
         */
        findByObservableId: function findByObservableId(responseId, parsedData, makeNotDeleteable) {
            if (parsedData.length > 0) {
                var i,
                    k;
                for (i = 0; i < parsedData.length; i++) {
                    if (responseId === parsedData[i].id()) {
                        if (makeNotDeleteable) {
                            parsedData[i].hasAnswers(true);
                        }
                        return parsedData[i];
                    }
                    if (parsedData[i].answers().length > 0) {
                        for (k = 0; k < parsedData[i].answers().length; k++) {
                            if (responseId === parsedData[i].answers()[k].id()) {
                                if (makeNotDeleteable) {
                                    parsedData[i].answers()[k].hasAnswers(true);
                                }
                                return parsedData[i].answers()[k];
                            }
                        }
                    }
                }
            }
            return false;
        },

        /**
         * Добавление юзера к новому комментарию
         * @param  {object} comment      Объект комментария
         * @param  {object} user            Объект пользователя
         * @param  {Array} parsedData Массив комментариев
         * @return {object}              Объект готового комментария
         */
        newCommentAddedUser: function (comment, user, parsedData) {
            if (user.success) {
                var commentInstance = Object.create(Comment),
                    userInstance = Object.create(User),
                    commentObj = ko.mapping.fromJS({}),
                    userObj = ko.mapping.fromJS({});

                ko.mapping.fromJS(userInstance.init(user.data), userObj);
                ko.mapping.fromJS(commentInstance.init(comment), commentObj);


                commentObj.editorConfig = Comment.editorConfig;
                commentObj.color(this.prevColor(this.getFirstColor(parsedData)));
                commentObj.user = userObj;

                return commentObj;
            }
            return false;
        },

        /**
         * Добавление юзера к новому ответу
         * @param  {object} comment      Объект комментария
         * @param  {object} user            Объект пользователя
         * @param  {Array} parsedData Массив комментариев
         * @return {object}              Объект готового комментария
         */
        newAnswer: function (comment, user, parsedData) {

            if (user.success) {
                var commentInstance = Object.create(Comment),
                    userInstance = Object.create(User),
                    commentObj = ko.mapping.fromJS({}),
                    userObj = ko.mapping.fromJS({}),
                    parentIdInList,
                    responseToComment;

                parentIdInList = this.findIfAnswer(comment, parsedData);

                ko.mapping.fromJS(userInstance.init(user.data), userObj);
                ko.mapping.fromJS(commentInstance.init(comment), commentObj);

                responseToComment = this.findByObservableId(comment.responseId, parsedData, true);

                commentObj.user = userObj;
                commentObj.editorConfig = Comment.editorConfig;
                commentObj.answerTo.fullName = responseToComment.user.fullName;
                commentObj.answerTo.profileUrl = responseToComment.user.profileUrl;


                return {
                    parentId: parentIdInList,
                    comment: commentObj
                };
            }

            return false;
        }

    };

    return CommentsController;
});