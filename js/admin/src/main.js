import app from 'flarum/app';

import CnuSettingsModal from 'cnuer/auth/cnu/components/CnuSettingsModal';

app.initializers.add('cnuer-auth-cnu', () => {
  app.extensionSettings['cnuer-auth-cnu'] = () => app.modal.show(new CnuSettingsModal());
});
