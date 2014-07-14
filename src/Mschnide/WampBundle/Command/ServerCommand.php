<?php

namespace Mschnide\WampBundle\Command;

use Mschnide\WampBundle\WAMP\AuthenticationProvider;
use Mschnide\WampBundle\WAMP\Manager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thruway\Peer\Router;
use Thruway\Transport\RatchetTransportProvider;

/**
 * Description of ServerCommand
 *
 * @author Markus Schnider <mschnide@gmail.com>
 */
class ServerCommand extends ContainerAwareCommand
{

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    protected function configure()
    {
        $this
            ->setName('mschnide:wamp:server')
            ->setDescription('Starts the WAMP2 Server')
            ->addArgument('server', null, 'server name', '0.0.0.0')
            ->addArgument('port', null, 'server port', '8880')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $server = $this->input->getArgument('server');
        $port = (int) $this->input->getArgument('port');

        $manager = new Manager($this->getContainer(), 'realm1', $this->output);
        $authProvider = new AuthenticationProvider($this->getContainer());

        $transportProvider = new RatchetTransportProvider($server, $port);

        $router = new Router();
        $router->addTransportProvider($transportProvider);
        $router->setManager($manager);
        $router->setAuthenticationProvider($authProvider);


        $this->output->writeln('Starting wamp: ' . $server . ':' . $port);
        $router->start();
    }

}
