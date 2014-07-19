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
 * @author Markus Schnider <mschnide@gmail.com>
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

        $functions = $this->container->getParameter('mschnide_wamp.client.functions');
        foreach ($functions as $function) {
            $service = $this->container->get($function);
            if ($service instanceof Functions\FunctionInterface) {
                $name = $service->getName();
                $call = array($service, $service->getFunctionName());
                $this->getCallee()->register($session, $name, $call);
            }
        }
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
    public function getEcho($msg)
    {
        $this->output->writeln('echo: ' . print_r($msg, true));

        return $msg;
    }

    /**
     * get add2
     *
     * @param array $parameters
     *
     * @return float
     */
    public function getAdd2($parameters = array())
    {
        $this->output->writeln('add2: ' . print_r($parameters, true));

        return array_sum($parameters);
    }

}
