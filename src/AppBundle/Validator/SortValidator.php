<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 02.10.2017
 * Time: 1:35
 */

namespace AppBundle\Validator;


class SortValidator extends ApiValidator
{
    private $param = [];

    public function getMessage()
    {
        return 'Sort value must be one of this ' . implode(',', $this->param) . ' values';
    }

    public function validate($value)
    {
        if (in_array($value, $this->getParam())) {
            return true;
        } else {
            return false;
        }
    }

    public function getParam()
    {
        return $this->param;
    }

    public function setParam(array $param)
    {
        $this->param = $param;
    }
}
