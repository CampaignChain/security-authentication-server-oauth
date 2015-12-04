<?php
/*
 * This file is part of the CampaignChain package.
 *
 * (c) CampaignChain Inc. <info@campaignchain.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CampaignChain\Security\Authentication\Server\OAuthBundle\Controller;

use CampaignChain\Security\Authentication\Server\OAuthBundle\Form\Type\AppType;
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
        $form = $this->createForm(new AppType(), $formData);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $clientManager = $this->get('fos_oauth_server.client_manager.default');
            $client = $clientManager->createClient();
            $client->setName($form->get('name')->getData());
            $client->setRedirectUris($form->get('redirectUris')->getData());
            $client->setAllowedGrantTypes(array('token', 'authorization_code'));
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
        $form = $this->createForm(new AppType(), $app);

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
