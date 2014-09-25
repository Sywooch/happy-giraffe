define(["jquery", "knockout"], function($, ko) {

   var Model = {

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

   return Model;
});