<?php
// src/EventSubscriber/MenuBuilderSubscriber.php
namespace App\EventSubscriber;

use KevinPapst\AdminLTEBundle\Event\SidebarMenuEvent;
use KevinPapst\AdminLTEBundle\Event\ThemeEvents;
use KevinPapst\AdminLTEBundle\Model\MenuItemModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MenuBuilderSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ThemeEvents::THEME_SIDEBAR_SETUP_MENU => ['onSetupMenu', 100],
        ];
    }

    public function onSetupMenu(SidebarMenuEvent $event)
    {
        $students = new MenuItemModel('blogId', 'Gestions des étudiants', '', [], 'fas fa-tachometer-alt');

        $students->addChild(
            new MenuItemModel('ChildOneItemId', 'Liste des étudiants', 'students', [], 'fas fa-users')
        )
            ->addChild(
                new MenuItemModel('ChildTwoItemId', 'Ajouter un étudiant', 'new_student', [], 'fas fa-user-plus')
            )
            ->addChild(
                new MenuItemModel('ChildThreeItemId', 'Ajouter des notes', 'new_score', [], 'fas fa-star-half-alt')
            );

        $event->addItem($students);

        $this->activateByRoute(
            $event->getRequest()->get('_route'),
            $event->getItems()
        );
    }

    /**
     * @param string $route
     * @param MenuItemModel[] $items
     */
    protected function activateByRoute($route, $items)
    {
        foreach ($items as $item) {
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } elseif ($item->getRoute() == $route) {
                $item->setIsActive(true);
            }
        }
    }
}