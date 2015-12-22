<?php
/*
 * This file is part of the CampaignChain package.
 *
 * (c) CampaignChain, Inc. <info@campaignchain.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CampaignChain\Security\Authentication\Server\OAuthBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function detailsTab(FactoryInterface $factory, array $options)
    {
        $id = $this->container->get('request')->get('id');

        $menu = $factory->createItem('root');

        $menu->addChild(
            'List',
            array(
                'route' => 'campaignchain_security_authentication_server_oauth_apps'
            )
        );
        $menu->addChild(
            'Edit',
            array(
                'route' => 'campaignchain_security_authentication_server_oauth_apps_edit',
                'routeParameters' => array(
                    'id' => $id
                )
            )
        );
        $menu->addChild(
            'Details',
            array(
                'route' => 'campaignchain_security_authentication_server_oauth_apps_read',
                'routeParameters' => array(
                    'id' => $id
                )
            )
        );

        return $menu;
    }
}