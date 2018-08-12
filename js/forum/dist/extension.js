'use strict';

System.register('cnuer/auth/cnu/main', ['flarum/extend', 'flarum/app', 'flarum/components/LogInButtons', 'flarum/components/LogInButton'], function (_export, _context) {
  "use strict";

  var extend, app, LogInButtons, LogInButton;
  return {
    setters: [function (_flarumExtend) {
      extend = _flarumExtend.extend;
    }, function (_flarumApp) {
      app = _flarumApp.default;
    }, function (_flarumComponentsLogInButtons) {
      LogInButtons = _flarumComponentsLogInButtons.default;
    }, function (_flarumComponentsLogInButton) {
      LogInButton = _flarumComponentsLogInButton.default;
    }],
    execute: function () {

      app.initializers.add('cnuer-auth-cnu', function () {
        extend(LogInButtons.prototype, 'items', function (items) {
          items.add('cnu', m(
            LogInButton,
            {
              className: 'Button LogInButton--cnu',
              path: '/auth/cnu' },
            app.translator.trans('cnuer-auth-cnu.forum.log_in.with_cnu_button')
          ));
        });
      });
    }
  };
});