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
            'identifier'   => $this->settings->get('cnuer-auth-cnu.api_key'),
            'secret'       => $this->settings->get('cnuer-auth-cnu.api_secret'),
            'callback_uri' => $redirectUri
        ]);
        //'callback_uri' => $this->url->toRoute('auth/cnu')

        $session = $request->getAttribute('session');

        $queryParams = $request->getQueryParams();
        $oAuthCode = array_get($queryParams, 'code');

        if (!$oAuthCode) {
            $temporary = $server->gotoAuthUrl();

            $session->set('temporary_credentials', serialize($temporary));
            $session->save();

            exit;
        } else {
            // get token
            $oAuthToken = $server->getAccessToken($oAuthCode);
            $info = $server->getUserInfo($oAuthToken);
        }

        $temporaryCredentials = unserialize($session->get('temporary_credentials'));

        $identification = ['cnu_id' => $server->get('cnu_id')];
        $suggestions = [
            'username' => $server->get('uname'),
            'avatarUrl' => ''
        ];

        return $this->authResponse->make($request, $identification, $suggestions);
    }
}