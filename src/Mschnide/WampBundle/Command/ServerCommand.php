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
            ->addArgument('server', null, 'server name', '')
            ->addArgument('port', null, 'server port', 0)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $server = $this->input->getArgument('server');
        $port = (int) $this->input->getArgument('port');
        if (empty($server)) {
            $server = $this->getContainer()->getParameter('mschnide_wamp.server');
        }
        if ($port <= 0) {
            $port = (int) $this->getContainer()->getParameter('mschnide_wamp.port');
        }

        $manager = $this->getContainer()->get('mschnide_wamp.manager');
        $authProvider = $this->getContainer()->get('mschnide_wamp.authenticationprovider');
        $onOpenTransporter = $this->getContainer()->get('mschnide_wamp.onopentransport');

        $transportProvider = new RatchetTransportProvider($server, $port);

        $router = new Router(null, $manager);
        $router->addTransportProvider($transportProvider);
        $router->setAuthenticationProvider($authProvider);
        $router->onOpen($onOpenTransporter);


        $this->output->writeln('Starting wamp: ' . $server . ':' . $port);
        $router->start();
    }

}
