<?php

namespace Mschnide\WampBundle\WAMP\Functions;

/**
 * Description of EchoFunction
 *
 * @author Markus Schnider <mschnide@gmail.com>
 */
class AddFunction implements FunctionInterface
{

    /**
     * get call name
     *
     * @return string
     */
    public function getName()
    {
        return 'com.mschnide.wamp.add2';
    }

    /**
     * get function name
     *
     * @return string
     */
    public function getFunctionName()
    {
        return 'getAdd';
    }

    /**
     * the function itself
     *
     * @param array $parameters
     *
     * @return int
     */
    public function getAdd($parameters)
    {
        return array_sum($parameters);
    }

}
