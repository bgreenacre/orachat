<?php

namespace Ora\Chat\Traits;

use Illuminate\Support\MessageBag;

trait EloquentRulesAndErrorsTrait {

    protected $rules = array();
    protected $conditionalRules = array();
    protected $errors;

    public function setRules(array $rules, $add = false)
    {
        if ($add !== false)
        {
            $this->rules = array_merge($this->rules, $rules);
        }
        else
        {
            $this->rules = $rules;
        }

        return $this;
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function setConditionalRules(array $rules, $add = false)
    {
        if ($add !== false)
        {
            $this->conditionalRules = array_merge($this->conditionalRules, $rules);
        }
        else
        {
            $this->conditionalRules = $rules;
        }

        return $this;
    }

    public function getConditionalRules()
    {
        return $this->conditionalRules;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setErrors(MessageBag $messages)
    {
        $this->errors = $messages;

        return $this;
    }

}