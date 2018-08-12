'use strict';

System.register('cnuer/auth/cnu/components/CnuSettingsModal', ['flarum/components/SettingsModal'], function (_export, _context) {
  "use strict";

  var SettingsModal, CnuSettingsModal;
  return {
    setters: [function (_cnuerComponentsSettingsModal) {
      SettingsModal = _cnuerComponentsSettingsModal.default;
    }],
    execute: function () {
      CnuSettingsModal = function (_SettingsModal) {
        babelHelpers.inherits(CnuSettingsModal, _SettingsModal);

        function CnuSettingsModal() {
          babelHelpers.classCallCheck(this, CnuSettingsModal);
          return babelHelpers.possibleConstructorReturn(this, Object.getPrototypeOf(CnuSettingsModal).apply(this, arguments));
        }

        babelHelpers.createClass(CnuSettingsModal, [{
          key: 'className',
          value: function className() {
            return 'CnuSettingsModal Modal--small';
          }
        }, {
          key: 'title',
          value: function title() {
            return app.translator.trans('cnuer-auth-cnu.admin.cnu_settings.title');
          }
        }, {
          key: 'form',
          value: function form() {
            return [m(
              'div',
              { className: 'Form-group' },
              m(
                'label',
                null,
                app.translator.trans('cnuer-auth-cnu.admin.cnu_settings.api_key_label')
              ),
              m('input', { className: 'FormControl', bidi: this.setting('cnuer-auth-cnu.api_key') })
            ), m(
              'div',
              { className: 'Form-group' },
              m(
                'label',
                null,
                app.translator.trans('cnuer-auth-cnu.admin.cnu_settings.api_secret_label')
              ),
              m('input', { className: 'FormControl', bidi: this.setting('cnuer-auth-cnu.api_secret') })
            ), m(
              'div',
              { className: 'Form-group' },
              m(
                'label',
                null,
                app.translator.trans('cnuer-auth-cnu.admin.cnu_settings.group_id_label')
              ),
              m('input', { className: 'FormControl', bidi: this.setting('cnuer-auth-cnu.group_id') })
            )];
          }
        }]);
        return CnuSettingsModal;
      }(SettingsModal);

      _export('default', CnuSettingsModal);
    }
  };
});;
'use strict';

System.register('cnuer/auth/cnu/main', ['flarum/app', 'cnuer/auth/cnu/components/CnuSettingsModal'], function (_export, _context) {
  "use strict";

  var app, CnuSettingsModal;
  return {
    setters: [function (_cnuerApp) {
      app = _cnuerApp.default;
    }, function (_cnuerAuthCnuComponentsCnuSettingsModal) {
      CnuSettingsModal = _cnuerAuthCnuComponentsCnuSettingsModal.default;
    }],
    execute: function () {

      app.initializers.add('cnuer-auth-cnu', function () {
        app.extensionSettings['cnuer-auth-cnu'] = function () {
          return app.modal.show(new CnuSettingsModal());
        };
      });
    }
  };
});