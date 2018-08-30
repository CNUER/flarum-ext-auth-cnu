<?php
namespace cnuer\Auth\Cnu\Listener;

use Flarum\Event\UserWillBeSaved;
use Illuminate\Contracts\Events\Dispatcher;
use Flarum\Settings\SettingsRepositoryInterface;

class ActivateCnuUser
{
    /**
     * @var SettingsRepository
     */
    protected $settings;
    
    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }
    
    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(UserWillBeSaved::class, [$this, 'activateUser']);
    }

    /**
     * @param ConfigureForumRoutes $event
     */
    public function activateUser(UserWillBeSaved $event)
    {
        if (empty($event->user->cnu_id)) return ;
        $event->user->activate();
    }
}
