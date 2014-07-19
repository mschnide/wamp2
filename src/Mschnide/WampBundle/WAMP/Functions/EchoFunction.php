<?php

namespace Mschnide\WampBundle\WAMP\Functions;

/**
 * Description of EchoFunction
 *
 * @author Markus Schnider <mschnide@gmail.com>
 */
class EchoFunction implements FunctionInterface
{

    /**
     * get call name
     *
     * @return string
     */
    public function getName()
    {
        return 'com.mschnide.wamp.echo';
    }

    /**
     * get function name
     *
     * @return string
     */
    public function getFunctionName()
    {
        return 'getEcho';
    }

    /**
     * the function itself
     *
     * @param string $message
     *
     * @return string
     */
    public function getEcho($message)
    {
        return $message;
    }

}
