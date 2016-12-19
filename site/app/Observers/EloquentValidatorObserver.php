<?php

namespace Ora\Chat\Observers;

use Closure;
use Illuminate\Validation\Factory as Validator;
use Ora\Chat\Interfaces\EloquentValidationInterface;

abstract class EloquentValidatorObserver {

    protected $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function saving($model)
    {
        // Merge the observers validation rules and whatever
        // the model has for rules if the model implements
        // Rocko\Interfaces\EloquentValidationInterface
        $rules            = $this->getRules($model);
        $conditionalRules = $this->getConditionalRules($model);

        if ($model instanceof EloquentValidationInterface)
        {
            $rules            = array_merge($rules, $model->getRules());
            $conditionalRules = array_merge($conditionalRules, $model->getConditionalRules());
        }

        // No rules to validate so just return boolean true.
        if (empty($rules) && empty($conditionalRules))
        {
            return true;
        }

        $data  = $model->getAttributes();

        $validator = $this->validator->make($data, $rules);

        if ( ! empty($conditionalRules))
        {
            foreach ($conditionalRules as $field => $rules)
            {
                $callback = array_pop();

                if ($callback instanceof Closure)
                {
                    $validator->sometimes($name, $rules, $callback);
                }
            }
        }

        if ($validator->fails())
        {
            $model->setErrors($validator->messages());

            return false;
        }

        return true;
    }

    public function getRules($model)
    {
        return array();
    }

    public function getConditionalRules($model)
    {
        return array();
    }

}