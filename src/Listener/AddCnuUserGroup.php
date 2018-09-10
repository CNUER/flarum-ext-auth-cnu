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
        //是否CNU用户
        if (empty($event->user->cnu_id)) {
            if (preg_match('#^(\d+)@(mail\.)?cnu\.edu\.cn$#', $event->user->email, $m)) {
                $event->user->cnu_id = $m[1];
            } elseif (preg_match('#@(mail\.)?cnu\.edu\.cn$#', $event->user->email)) {
                
            } else {
                return;
            }
        }
        
        $group = (int) $this->settings->get('cnuer-auth-cnu.group_id');
        // 没有配置用户组
        if (empty($group)) return;
        //查当前用户组
        $ingroup = $event->user->groups()->first(['id']);
        
        if (!empty($ingroup)) {
            if ($ingroup == $group) return;//已经在用户组中
            $event->user->groups()->detach();//解除其他用户组关联-黑名单可能有问题
        }
        
        $event->user->groups()->attach($group);
        
    }
}
