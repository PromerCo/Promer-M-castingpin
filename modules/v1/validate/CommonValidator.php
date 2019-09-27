<?php
namespace mcastingpin\modules\v1\validate;

use yii\validators\Validator;

class CommonValidator extends Validator {

    public function init()
    {
        parent::init();
        $this->message = 'Invalid status input.';
    }

}
