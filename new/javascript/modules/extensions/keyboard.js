define(['jquery', 'knockout', 'extensions/helpers'], function keyboardHandler($, ko, Helpers) {
    var Keyboard = {
      sliderKeys: {
        'left': 37,
        'right': 39,
        'space': 32,
        'esc': 27
      },
      onHandler: function onHandler(event, keys) {
          return (keys !== undefined) ? Helpers.hasOwnValue(event.keyCode, keys) : false;
      }
    };
    return Keyboard;
});
