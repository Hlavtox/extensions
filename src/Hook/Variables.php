<?php
namespace BulkGate\Extensions\Hook;

use BulkGate\Extensions\SmartObject;

/**
 * @author Lukáš Piják 2018 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */
class Variables extends SmartObject
{
    /** @var array */
    private $variables = array();

    public function __construct(array $variables = array())
    {
        $this->variables = $variables;
    }

    public function set($key, $value, $alternative = '')
    {
        if(is_scalar($value) && strlen($value) > 0)
        {
            $this->variables[$key] = $value;
        }

        if(!isset($this->variables[$key]))
        {
            if(is_scalar($alternative) && strlen($alternative) > 0)
            {
                $this->variables[$key] = (string) $alternative;
            }
            else
            {
                $this->variables[$key] = '';
            }
        }

        return $this;
    }

    public function get($key, $default = false)
    {
        if(isset($this->variables[$key]))
        {
            return $this->variables[$key];
        }
        return $default;
    }

    public function toArray()
    {
        return (array) $this->variables;
    }

    public function __toString()
    {
        $output = '$php = array('.PHP_EOL;

        foreach ($this->variables as $key => $variable)
        {
            $output .= "\t".'\''.$key.'\' => \''.$variable.'\','.PHP_EOL;
        }

        $output .= ");";

        return $output;
    }
}