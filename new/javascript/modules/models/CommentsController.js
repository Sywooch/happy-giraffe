define(['jquery', 'knockout', 'user-control', 'user-model'], function($, ko, UserData, User) {

   var CommentsController = {

      /**
       * Url для получения списка комментариев
       * @type {String}
       */
      getListUrl: '/api/comments/list/',

      /**
       * Url для получения одного комментария
       * @type {String}
       */
      getComment: '/api/comments/get/',

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

      createPackList: function (array) {
        if (array.length > 0) {
          for (var i=0; i < array.length; i++) {
            array[i] = { id: array[i] };
          }
          return array;
        }
        return false
      },

      commentsColors: ['lilac', 'yellow', 'red', 'blue', 'green'],

      nextColor: function nextColor(color) {
        if (color === undefined) {
          return this.commentsColors[0];
        }
        return this.commentsColors[($.inArray(color, this.commentsColors) + 1) % this.commentsColors.length];
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

      allDataReceived: function allDataReceived(dataUser, dataComments) {
        var dataCounterSafe,
            commentsArray = [];

        for ( var dataCounter = 0; dataCounter < dataComments.length; dataCounter++ ) {

          var userKey = UserData.isUserInPack(dataComments[dataCounter].authorId, dataUser);

          if (userKey !== false) {
            dataComments[dataCounter].user = {};
            var user = Object.create( User );
            dataComments[dataCounter].user = user.init(dataUser[userKey].data);
          }

          if ( dataComments[dataCounter].responseId === 0 ) {
            dataComments[dataCounter].answers = [];
            var newArrayCounter = commentsArray.push(dataComments[dataCounter]);
            commentsArray[newArrayCounter - 1].color = this.nextColor(commentsArray[newArrayCounter - 2].color);
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

            if ( $.inArray( notReadyData[rootCount].authorId, userPack.pack ) === -1 ) {
              userPack.pack.push(notReadyData[rootCount].authorId);
            }
          }

          userPack.pack = this.createPackList(userPack.pack);

          return { commentsData: notReadyData, userPack: userPack};
        }
        return false;
      },

      prepareDataWithUser: function prepareDataWithUser(dataUser) {
        if (dataUser.success === true) {
            this.parse;
        }
        return false;
      },

      getSuccess: function getSuccess( data ) {
         console.log(data);
      },


      errorGetting: function errorGetting( jqXHR, textStatus, errorThrown ) {
        console.log( errorThrown );
      },

      /**
       * [get асинхронный запрос к api]
       * @param  {string} url        url к которому обращаемся
       * @param  {object} paramsData объект с данными для запроса к API
       * @return {$.ajax}            Возвращает объект $.ajax
       */
      get: function get( url, paramsData ) {
         return $.ajax(
           {
               type: "POST",
               url: url,
               data:  JSON.stringify(paramsData),
               dataType: 'json'
            }
          );
      }
   }

   return CommentsController;
});