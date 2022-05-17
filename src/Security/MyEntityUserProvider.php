<?php

namespace App\Security;

use HWI\Bundle\OAuthBundle\Security\Core\User\EntityUserProvider;
use App\Entity\User;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use PhpParser\Node\Stmt\Return_;
use Symfony\Component\Security\Core\User\UserInterface;

class MyEntityUserProvider extends EntityUserProvider
{
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $resourceOwnerName = $response->getResourceOwner()->getName();

        if (!isset($this->properties[$resourceOwnerName])) {
            throw new \RuntimeException(sprintf("No property defined for entity for resource owner '%s'.", $resourceOwnerName));
        }

        $serviceName = $response->getResourceOwner()->getName();
        $setterId = 'set'. ucfirst($serviceName) . 'ID';
        $setterAccessToken = 'set'. ucfirst($serviceName) . 'AccessToken';

        // unique integer
        $username = $response->getUsername();
        $email = $response->getEmail();
        if (null === $user = $this->findUser([$this->properties[$resourceOwnerName] => $username])) {
            // TODO: Create new user
            if (null === $user = $this->findUser(['email' => $email])){
                $user = new User();
                $user->setEmail($response->getEmail());
                $user->setPassword(md5(uniqid('', true)));
            }
            $user->$setterId($username);
        }

        $user->$setterAccessToken($response->getAccessToken());
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }
}
