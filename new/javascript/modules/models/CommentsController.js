define(['jquery', 'knockout', 'user-control', 'user-model', 'comment-model', 'knockout.mapping'], function($, ko, UserControl, User, Comment) {

   var CommentsController = {

      /**
       * Размер аватары пользователей для комментариев
       * @type {Number}
       */
      commentAvatarSize: 40,

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
            commentsArray[newArrayCounter - 1].answers.push(dataComments[dataCounter]);
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

       findIfAnswer: function (comment, parsedData) {
           var commentObj;
           if (parsedData.length > 0) {
               for (var i=0; i < parsedData.length; i++) {
                   if(comment.responseId === parsedData[i].id()) {
                       commentObj = i;
                   }
               }

           }
           return commentObj;

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

               commentObj.user = userObj;

               return { parentId: parentIdinList, comment: commentObj };
           }
           return false;
       }

   }

   return CommentsController;
});