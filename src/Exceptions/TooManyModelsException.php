<?php
namespace TecBeast\FrontendRights\Exceptions;

class TooManyModelsException extends \Exception
{
    public function __construct($property, $value, $message = '', $code = 0, Exception $previous = null) {
        $message .= 'Too many models found for property ' . $property .  ' with value ' . $value ' .';
        parent::__construct($message, $code, $previous);
    }
}
