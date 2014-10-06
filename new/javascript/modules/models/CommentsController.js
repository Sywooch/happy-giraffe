define(['jquery', 'knockout', 'user-control', 'user-model', 'comment-model', 'knockout.mapping'], function($, ko, UserControl, User, Comment) {

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
         rootCount: 10,
         dtimeFrom: 0
        };
      },

      /**
       * создания пака из массива с id пользователей
       * @param  {array} array Массив с id пользователей
       * @return {array}       Массив с объектами типа { id: number }
       */
      createPackList: function createPackList(array) {
        if (array.length > 0) {
          /**
           * Добавляем автора к пользователям
           */
          array = UserControl.checkForMe(array);

          for (var i=0; i < array.length; i++) {
            array[i] = { id: array[i] };
          }

          return array;
        }
        return false
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
          return commentsData[0].color();
      },

      /**
       * [checkChildrenNotice собирает информацию о наличии детей]
       * @param {int} counter счетчик
       * @param {array} array   Массив комментариев
       */
      checkChildrenNotice: function checkChildrenNotice( counter, array ) {
        if ( counter+1 !== array.length && array[counter+1].rootId === array[counter].id ) {
            return true;
        }
        return false;
      },

      /**
       * Мердж данных юзеров и комментариев, все ответы в отдельное свойство и массив рутового комментария, цвет рутового комментария
       * @param  {array} dataUser     Данные о юзерах
       * @param  {array} dataComments Данные о комментариях
       * @return {array}              Смердженный массив комментариев
       */
      allDataReceived: function allDataReceived(dataUser, dataComments) {
        var dataCounterSafe,
            commentsArray = [],
            color;

        for ( var dataCounter = 0; dataCounter < dataComments.length; dataCounter++ ) {
          var userKey = UserControl.isUserInPack(dataComments[dataCounter].authorId, dataUser);

          if (userKey !== false) {
            dataComments[dataCounter].user = {};
            var user = Object.create( User );
            dataComments[dataCounter].user = user.init(dataUser[userKey].data);
          }

          if ( dataComments[dataCounter].responseId === 0 ) {
            dataComments[dataCounter].answers = [];
            var newArrayCounter = commentsArray.push(dataComments[dataCounter]);
            if (newArrayCounter === 1) {
              color = this.commentsColors[0];
            }
            else {
              color = this.nextColor(color);
            }
            commentsArray[newArrayCounter - 1].color = color;
          }
          else {
              var response = dataComments[dataCounter];
              var responseToComment = this.findById(response.responseId, dataComments);

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
       * @return {array}              объект данных с комментариями и пользователями
       */
      parseData: function parseData( parsingData ) {
        if (parsingData.success === true) {
          var notReadyData = parsingData.data.list,
              userPack = { pack: [], avatarSize: this.commentAvatarSize };

          for ( var rootCount = 0; rootCount < notReadyData.length; rootCount++ ) {

            var comment = Object.create( Comment );

            notReadyData[rootCount] = comment.init( notReadyData[rootCount] );

            if ( $.inArray( notReadyData[rootCount].authorId, userPack.pack ) === -1 ) {
              userPack.pack.push(notReadyData[rootCount].authorId);
            }
          }

          userPack.pack = this.createPackList(userPack.pack);

          return { commentsData: notReadyData, userPack: userPack};
        }
        return false;
      },

      /**
       * Создание отдельного комментария
       * @param  {string} entity
       * @param  {int} entityId
       * @param  {sting} text
       * @param  {id} responseId
       * @return {object}
       */
      createComment: function createComment(entity, entityId, text, responseId) {
        if (responseId === undefined) {

          return {
            entity: entity,
            entityId: entityId,
            text: text
          }
        }

        return {
          entity: entity,
          entityId: entityId,
          text: text,
          responseId: responseId
        }
      },


      /**
       * Проверка массива на присутстивие элемента с определенным свойством
       * @param  {object Comment}   comment    Объект комментария
       * @param  {Observable array} parsedData Массив с комментариями
       * @return {Object}                      Объект комментария
       */
      removedStatus: function (comment, parsedData) {

        var commentObj;

        if (parsedData.length > 0) {
          for (var i=0; i < parsedData.length; i++) {
            if(comment.id === parsedData[i].id()) {
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
       findInAnswers: function (comment, answersArray) {
           var commentObj,
               id = comment.id;

           if (answersArray.length > 0) {
               for (var i=0; i < answersArray.length; i++) {
                   if(id === answersArray[i].id()) {
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
       findIfAnswer: function (comment, parsedData) {
           var commentObj,
               id = comment.responseId;

           if (comment.rootId !== 0) {
              id = comment.rootId;
           }
           if (parsedData.length > 0) {
               for (var i=0; i < parsedData.length; i++) {
                   if(id === parsedData[i].id()) {
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
       findById: function (responseId, parsedData) {
           if (parsedData.length > 0) {
               for (var i=0; i < parsedData.length; i++) {
                   if(responseId === parsedData[i].id) {
                       return parsedData[i];
                   }
                   if ( parsedData[i].answers.length > 0 ) {
                       for (var k=0; k < parsedData[i].answers.length; k++) {
                           if(responseId === parsedData[i].answers[k].id) {
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
       findByObservableId: function (responseId, parsedData, makeNotDeleteable) {
           if (parsedData.length > 0) {
               for (var i=0; i < parsedData.length; i++) {
                   if(responseId === parsedData[i].id()) {
                       if (makeNotDeleteable) {
                           parsedData[i].hasAnswers(true);
                       }
                       return parsedData[i];
                   }
                   if ( parsedData[i].answers().length > 0 ) {
                       for (var k=0; k < parsedData[i].answers().length; k++) {
                           if(responseId === parsedData[i].answers()[k].id()) {
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
       * @param  {Comment object} comment      Объект комментария
       * @param  {User object} user            Объект пользователя
       * @param  {Observable array} parsedData Массив комментариев
       * @return {Comment Object}              Объект готового комментария
       */
      newCommentAddedUser: function (comment, user, parsedData) {
        if ( user.success ) {
          var commentInstance = Object.create( Comment ),
              userInstance = Object.create( User ),
              commentObj = ko.mapping.fromJS({}),
              userObj = ko.mapping.fromJS({});

          ko.mapping.fromJS( userInstance.init( user.data ), userObj );
          ko.mapping.fromJS( commentInstance.init( comment ), commentObj );


          commentObj.editorConfig = Comment.editorConfig;
          commentObj.color( this.prevColor( this.getFirstColor(parsedData) ) );
          commentObj.user = userObj;

          return commentObj;
        }
        return false;
      },

       /**
        * Добавление юзера к новому ответу
        * @param  {Comment object} comment      Объект комментария
        * @param  {User object} user            Объект пользователя
        * @param  {Observable array} parsedData Массив комментариев
        * @return {Comment Object}              Объект готового комментария
        */
       newAnswer: function (comment, user, parsedData) {

           if ( user.success ) {
               var commentInstance = Object.create( Comment ),
                   userInstance = Object.create( User ),
                   commentObj = ko.mapping.fromJS({}),
                   userObj = ko.mapping.fromJS({}),
                   parentIdinList;

               parentIdinList = this.findIfAnswer(comment, parsedData);

               ko.mapping.fromJS( userInstance.init( user.data ), userObj );
               ko.mapping.fromJS( commentInstance.init( comment ), commentObj );

               var responseToComment = this.findByObservableId(comment.responseId, parsedData, true);

               commentObj.user = userObj;
               commentObj.editorConfig = Comment.editorConfig;
               commentObj.answerTo.fullName = responseToComment.user.fullName;
               commentObj.answerTo.profileUrl = responseToComment.user.profileUrl;


               return { parentId: parentIdinList, comment: commentObj };
           }
           return false;
       }

   }

   return CommentsController;
});