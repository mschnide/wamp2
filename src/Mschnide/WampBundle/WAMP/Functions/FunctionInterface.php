<?php

namespace Mschnide\WampBundle\WAMP\Functions;

/**
 * FunctionInterface
 *
 * @author Markus Schnider <mschnide@gmail.com>
 */
interface FunctionInterface
{

    /**
     * @return string name of the call
     */
    public function getName();

    /**
     * @return string name of the function
     */
    public function getFunctionName();
}
