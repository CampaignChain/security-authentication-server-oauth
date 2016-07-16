<?php
/*
 * Copyright 2016 CampaignChain, Inc. <info@campaignchain.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
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