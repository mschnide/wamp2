<?php

namespace Mschnide\WampBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thruway\Peer\Router;
use Thruway\Transport\InternalClientTransportProvider;
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
        $manager->setOutput($this->output);
        $client = $this->getContainer()->get('mschnide_wamp.internalclient');
        $client->setOutput($this->output);
        $authProvider = $this->getContainer()->get('mschnide_wamp.authenticationprovider');

        $transportProvider = new RatchetTransportProvider($server, $port);
        $internalTransportProvider = new InternalClientTransportProvider($client);

        $router = new Router(null, $manager);
        $router->addTransportProvider($transportProvider);
        $router->addTransportProvider($internalTransportProvider);
        //$router->setAuthenticationProvider($authProvider);


        $this->output->writeln('Starting wamp: ' . $server . ':' . $port);
        $router->start();
    }

}
