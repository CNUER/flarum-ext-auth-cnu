<?php
namespace cnuer\Auth\Cnu;

use Flarum\Forum\AuthenticationResponseFactory;
use Flarum\Http\Controller\ControllerInterface;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\Forum\UrlGenerator;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\RedirectResponse;
use cnuer\Oauth\OauthCnu;

class CnuAuthController implements ControllerInterface
{
    /**
     * @var AuthenticationResponseFactory
     */
    protected $authResponse;

    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;
    protected $url;

    /**
     * @param AuthenticationResponseFactory $authResponse
     * @param SettingsRepositoryInterface $settings
     */
    public function __construct(
        AuthenticationResponseFactory $authResponse,
        SettingsRepositoryInterface $settings,
        UrlGenerator $url
    ) {
        $this->authResponse = $authResponse;
        $this->settings = $settings;
        $this->url = $url;
    }

    /**
     * @param Request $request
     * @return \Psr\Http\Message\ResponseInterface|RedirectResponse
     */
    public function handle(Request $request)
    {
        $redirectUri = (string) $request->getAttribute('originalUri', $request->getUri())->withQuery('');
        $server = new OauthCnu([
            'api_key'   => $this->settings->get('cnuer-auth-cnu.api_key'),
            'api_secret'       => $this->settings->get('cnuer-auth-cnu.api_secret'),
            'callback_uri' => $redirectUri
        ]);
        //'callback_uri' => $this->url->toRoute('auth/cnu')

        $session = $request->getAttribute('session');

        $queryParams = $request->getQueryParams();
        $oAuthCode = array_get($queryParams, 'code');

        if (!$oAuthCode) {
            $server->goToLogin();

            exit;
        } else {
            // $session->set('temporary_credentials', serialize($temporary));
            // $session->save();
            // get token
            $res = $server->getAccessToken($oAuthCode);
            $oAuthToken = $res->access_token;
            $res = $server->getUserInfo($oAuthToken);
            $info = $res->data;
        }

        // $temporaryCredentials = unserialize($session->get('temporary_credentials'));
        if (empty($info->user) || !is_numeric($info->user)) {
            throw new \Flarum\Core\Exception\InvalidConfirmationTokenException('cnu user info error');
        }

        $identification = ['cnu_id' => $info->user];
        $suggestions = [
            'username' => $info->name,
            'avatarUrl' => ''
        ];

        return $this->authResponse->make($request, $identification, $suggestions);
    }
}
