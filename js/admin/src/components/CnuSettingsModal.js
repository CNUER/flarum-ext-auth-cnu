import SettingsModal from 'flarum/components/SettingsModal';

export default class CnuSettingsModal extends SettingsModal {
  className() {
    return 'CnuSettingsModal Modal--small';
  }

  title() {
    return app.translator.trans('flarum-auth-cnu.admin.cnu_settings.title');
  }

  form() {
    return [
      <div className="Form-group">
        <label>{app.translator.trans('flarum-auth-cnu.admin.cnu_settings.api_key_label')}</label>
        <input className="FormControl" bidi={this.setting('flarum-auth-cnu.api_key')}/>
      </div>,

      <div className="Form-group">
        <label>{app.translator.trans('flarum-auth-cnu.admin.cnu_settings.api_secret_label')}</label>
        <input className="FormControl" bidi={this.setting('flarum-auth-cnu.api_secret')}/>
      </div>,
      
      <div className="Form-group">
        <label>{app.translator.trans('flarum-auth-cnu.admin.cnu_settings.group_id_label')}</label>
        <input className="FormControl" bidi={this.setting('flarum-auth-cnu.group_id')}/>
      </div>
    ];
  }
}
