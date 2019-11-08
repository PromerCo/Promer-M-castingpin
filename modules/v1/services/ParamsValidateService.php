<?php
namespace mcastingpin\modules\v1\services;

use mcastingpin\modules\v1\validate\ParamsValidateModel;
use yii\base\Component;
/**
 * Class ParamsValidateService
 * @package common\services\app
 * @method array getErrors(\string $attribute)
 * @method array getFirstErrors()
 * @method array getFirstError(\string $attribute)
 * @method array getErrorSummary(\boolean $showAllErrors)
 */
class ParamsValidateService extends Component
{
    /**
     * @var ParamsValidateModel 模型
     */
    private $model = null;
    public function init()
    {
        parent::init();
        $this->model = new ParamsValidateModel();
    }
    /**
     * @param array $data 数据项
     * @param array $rules 验证规则
     * @return bool
     */
    public function validate($data, $rules)
    {
        // 添加验证规则
        $this->model->setRules($rules);
        // 设置参数
        $this->model->load($data, '');
        // 进行验证
        return $this->model->validate();
    }
    public function __call($name, $params)
    {
        if ($this->model->hasMethod($name)) {
            return call_user_func_array([$this->model, $name], $params);
        } else {
            return parent::__call($name, $params);
        }
    }
}
