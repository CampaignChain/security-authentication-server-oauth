<?php

namespace CampaignChain\Security\Authentication\Server\OAuthBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CampaignChainSecurityAuthenticationServerOAuthBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSOAuthServerBundle';
    }
}
