<?php
/*
 * This file is part of the CampaignChain package.
 *
 * (c) CampaignChain, Inc. <info@campaignchain.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CampaignChain\Security\Authentication\Server\OAuthBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;

class AppType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $uris = array();

        if(isset($options['data'])){
            $client = $options['data'];
        }

        $builder
            ->add('name', 'text', array(
                'label' => 'Display Name',
                'required' => true,
                'attr' => array('placeholder' => 'My App')
            ))
            ->add(
                'redirectUris',
                'bootstrap_collection',
                array(
                    'label' => 'Redirect URIs',
                    'type' => 'url',
                    'required'           => true,
                    'auto_initialize'    => true,
                    'allow_add'          => true,
                    'allow_delete'       => true,
                    'add_button_text'    => 'Add URI',
                    'delete_button_text' => 'Delete URI',
                    'delete_empty'       => true,
                    'sub_widget_col'     => 9,
                    'button_col'         => 3,
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array());
    }

    public function getName()
    {
        return 'campaignchain_security_authentication_server_oauth_apps';
    }
}