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

namespace CampaignChain\Security\Authentication\Server\OAuthBundle\Controller;

use CampaignChain\Security\Authentication\Server\OAuthBundle\Form\Type\AppType;
use OAuth2\OAuth2;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AppController extends Controller
{
    public function indexAction(Request $request)
    {
        $qb = $this->getDoctrine()->getManager()->createQueryBuilder();
        $qb->select('c')
            ->from('CampaignChain\Security\Authentication\Server\OAuthBundle\Entity\Client', 'c')
            ->orderBy('c.name');
        $query = $qb->getQuery();
        $apps = $query->getResult();

        return $this->render(
            'CampaignChainSecurityAuthenticationServerOAuthBundle:App:index.html.twig',
            array(
                'page_title' => 'OAuth Server Apps',
                'apps' => $apps
            ));
    }

    public function newAction(Request $request)
    {
        $formData = array();
        $form = $this->createForm(AppType::class, $formData);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $clientManager = $this->get('fos_oauth_server.client_manager.default');
            $client = $clientManager->createClient();
            $client->setName($form->get('name')->getData());
            $client->setRedirectUris($form->get('redirectUris')->getData());
            $client->setAllowedGrantTypes([
                OAuth2::GRANT_TYPE_AUTH_CODE,
                OAuth2::GRANT_TYPE_CLIENT_CREDENTIALS,
                OAuth2::GRANT_TYPE_IMPLICIT,
                OAuth2::GRANT_TYPE_REFRESH_TOKEN,
            ]);
            $clientManager->updateClient($client);

            $this->addFlash('Added new App "'.$client->getName().'" with Key "'.$client->getPublicId().'"', 'success');

            return $this->redirect(
                $this->generateUrl('campaignchain_security_authentication_server_oauth_apps')
            );
        }
        return $this->render(
            'CampaignChainCoreBundle:Base:new.html.twig',
            array(
                'page_title' => 'Create New App for REST API',
                'form' => $form->createView(),
                'form_submit_label' => 'Save',
                'form_cancel_route' => 'campaignchain_security_authentication_server_oauth_apps',
            ));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $app = $em->getRepository('CampaignChainSecurityAuthenticationServerOAuthBundle:Client')
            ->find($id);

        if (!$app) {
            throw new \Exception(
                'No OAuth app found for id '.$id
            );
        }

        $formData = array();
        $form = $this->createForm(AppType::class, $app);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $em->persist($app);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'The app "'.$app->getName().'" was modified successfully.'
            );

            return $this->redirect($this->generateUrl('campaignchain_security_authentication_server_oauth_apps'));
        }

        return $this->render(
            'CampaignChainSecurityAuthenticationServerOAuthBundle:App:edit.html.twig',
            array(
                'page_title' => 'Edit App',
                'form' => $form->createView(),
                'form_submit_label' => 'Save',
                'form_cancel_route' => 'campaignchain_security_authentication_server_oauth_apps',
            ));
    }

    public function readAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $app = $em->getRepository('CampaignChainSecurityAuthenticationServerOAuthBundle:Client')
            ->find($id);
        if (!$app) {
            throw new \Exception(
                'No OAuth app found for id '.$id
            );
        }

        $tokens = $em->getRepository('CampaignChainSecurityAuthenticationServerOAuthBundle:AccessToken')
            ->findByClient($id);

        return $this->render(
            'CampaignChainSecurityAuthenticationServerOAuthBundle:App:read.html.twig',
            array(
                'page_title' => 'App Details',
                'oauth_app' => $app,
                'oauth_tokens' => $tokens,
            ));
    }
}
