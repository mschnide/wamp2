<?php

namespace Mschnide\WampBundle\WAMP;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Thruway\ClientSession;
use Thruway\Peer\Client;
use Thruway\Transport\TransportInterface;

/**
 * Description of Manager
 *
 * @author markus
 */
class InternalClient extends Client implements ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var string
     */
    protected $realm;

    /**
     *
     * @var ClientSession
     */
    protected $session;

    /**
     * constructor
     * 
     * @param ContainerInterface $container
     * @param string             $realm
     * @param OutputInterface    $output
     */
    public function __construct(ContainerInterface $container, $realm, OutputInterface $output = null)
    {
        parent::__construct($realm);
        $this->container = $container;
        $this->realm = $realm;
        $this->output = $output;
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * set output
     *
     * @param OutputInterface $output
     *
     * @return Manager
     */
    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;

        return $this;
    }

    /**
     *
     * @param ClientSession      $session
     * @param TransportInterface $transport
     */
    public function onSessionStart($session, $transport)
    {
        $this->output->writeln('Internal Session Started');
        $this->getCallee()->register($session, 'com.myapp.hello', array($this, 'getEcho'));
        $this->getCallee()->register($session, 'com.myapp.add2', array($this, 'getAdd2'));
    }

    /**
     * start
     */
    public function start()
    {
        // overwritten to start nothing
    }

    /**
     * get echo
     *
     * @param string $msg
     * 
     * @return string
     */
    protected function getEcho($msg)
    {
        return $msg;
    }

    /**
     * get add2
     *
     * @param array $parameters
     *
     * @return float
     */
    protected function getAdd2($parameters = array())
    {
        return array_sum($parameters);
    }

}
