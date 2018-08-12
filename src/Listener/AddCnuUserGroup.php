<?php
namespace cnuer\Auth\Cnu\Listener;

use Flarum\Event\UserWasActivated;
use Illuminate\Contracts\Events\Dispatcher;
use Flarum\Settings\SettingsRepositoryInterface;

class AddCnuUserGroup
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
        $events->listen(UserWasActivated::class, [$this, 'addCnuVaildGroup']);
    }

    /**
     * @param ConfigureForumRoutes $event
     */
    public function addCnuVaildGroup(UserWasActivated $event)
    {
        if (empty($event->user->cnu_id)) return ;
        $ingroup = $event->user->groups()->first(['id']);
        if (empty($ingroup)) {
            $group = (int) $this->settings->get('cnuer-auth-cnu.group_id');
            if ($group > 0) $event->user->groups()->attach($group);
        }
        
    }
}
