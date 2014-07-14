<?php

namespace Mschnide\WampBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="session")
 */
class Session
{

    /**
     * @ORM\Column(type="string", name="session_id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", name="session_value")
     */
    protected $value;

    /**
     * @ORM\Column(type="integer", name="session_time", length=11)
     */
    protected $time;

    /**
     * get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * get time
     *
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * set value
     *
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * set time
     *
     * @param int $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

}
