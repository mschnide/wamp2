<?php

namespace Mschnide\WampBundle\WAMP;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Thruway\Authentication\AuthenticationProviderInterface;

/**
 * Description of AuthenticationProvider
 *
 * @author Markus Schnider <mschnide@gmail.com>
 */
class AuthenticationProvider implements AuthenticationProviderInterface, ContainerAwareInterface
{

    /**
     * @var string
     */
    protected $id = null;

    /**
     * @var ContainerInterface
     */
    protected $container = null;

    /**
     * constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * authenticate
     *
     * @param mixed $token
     *
     * @return boolean
     */
    public function authenticate($token)
    {
        $token = $token;

        return true;
    }

    /**
     * get authentication id
     *
     * @return mixed
     */
    public function getAuthenticationId()
    {
        return $this->id;
    }

    /**
     * get authentication method
     *
     * @return mixed
     */
    public function getAuthenticationMethod()
    {
        return '';
    }

    /**
     * get authentication role
     *
     * @return mixed
     */
    public function getAuthenticationRole()
    {
        return '';
    }

    /**
     * supports
     *
     * @param string $type
     *
     * @return boolean
     */
    public function supports($type)
    {
        $type = $type;

        return true;
    }

    /**
     * set container
     *
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

}
