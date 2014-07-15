<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mschnide\WampBundle\WAMP;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Thruway\Message\Message;
use Thruway\Transport\TransportInterface;

/**
 * Description of OnOpenTransport
 *
 * @author markus
 */
class OnOpenTransport implements TransportInterface, ContainerAwareInterface
{

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
     * {@inheritdoc}
     */
    public function close()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getTransportDetails()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function sendMessage(Message $msg)
    {
        return $msg;
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

}
