<?php

namespace Mschnide\WampBundle\WAMP;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Thruway\ManagerInterface;

/**
 * Description of Manager
 *
 * @author markus
 */
class Manager implements ManagerInterface, ContainerAwareInterface // extends Client
{

    const LOG_DEBUG = 0;
    const LOG_INFO = 10;
    const LOG_WARNING = 20;
    const LOG_ERROR = 30;
    const LOG_CRITICAL = 40;
    const LOG_FATAL = 50;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var array
     */
    protected $callables;

    /**
     * @var string
     */
    protected $realm;

    /**
     * @var int
     */
    protected $logLevel = self::LOG_INFO;

    /**
     * constructor
     * 
     * @param ContainerInterface $container
     * @param string             $realm
     * @param OutputInterface    $output
     */
    public function __construct(ContainerInterface $container, $realm, OutputInterface $output = null, $logLevel = self::LOG_DEBUG)
    {
        $this->container = $container;
        $this->realm = $realm;
        $this->output = $output;
        $this->logLevel = $logLevel;
        $this->callables = array();
    }

    /**
     * add callable
     *
     * @param string $name
     * @param string $callback
     */
    public function addCallable($name, $callback)
    {
        $this->logDebug($name);

        $this->callables[] = array($name, $callback);
    }

    /**
     * {@inheritdoc}
     */
    public function logDebug($msg)
    {
        $this->container->get('logger')->debug($msg);
        if (!empty($this->output) && $this->logLevel <= self::LOG_DEBUG) {
            $this->output->writeln(date('c') . ': ' . 'DEBUG ' . $msg);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function logError($msg)
    {
        $this->container->get('logger')->error($msg);
        if (!empty($this->output) && $this->logLevel <= self::LOG_ERROR) {
            $this->output->writeln(date('c') . ': ' . 'ERROR ' . $msg);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function logInfo($msg)
    {
        $this->container->get('logger')->info($msg);
        if (!empty($this->output) && $this->logLevel <= self::LOG_INFO) {
            $this->output->writeln(date('c') . ': ' . 'INFO  ' . $msg);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function logIt($logLevel, $msg)
    {
        switch (strtoupper($logLevel)) {
            case 'DEBUG':
                $this->logDebug($msg);
                break;
            case 'INFO':
                $this->logInfo($msg);
                break;
            case 'WARNING':
                $this->logWarning($msg);
                break;
            case 'ERROR':
            case 'CRITICAL':
            case 'FATAL':
            default:
                $this->logError($msg);
                break;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function logWarning($msg)
    {
        $this->container->get('logger')->warning($msg);
        if (!empty($this->output) && $this->logLevel <= self::LOG_WARNING) {
            $this->output->writeln(date('c') . ': ' . 'WARN  ' . $msg);
        }
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
     * set log level
     * 
     * @param int $logLevel
     *
     * @return Manager
     */
    public function setLogLevel($logLevel)
    {
        $this->logLevel = $logLevel;

        return $this;
    }

}
