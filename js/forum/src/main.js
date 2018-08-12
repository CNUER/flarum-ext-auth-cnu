import { extend } from 'flarum/extend';
import app from 'flarum/app';
import LogInButtons from 'flarum/components/LogInButtons';
import LogInButton from 'flarum/components/LogInButton';

app.initializers.add('cnuer-auth-cnu', () => {
  extend(LogInButtons.prototype, 'items', function(items) {
    items.add('cnu',
      <LogInButton
        className="Button LogInButton--cnu"
        path="/auth/cnu">
        {app.translator.trans('cnuer-auth-cnu.forum.log_in.with_cnu_button')}
      </LogInButton>
    );
  });
});
