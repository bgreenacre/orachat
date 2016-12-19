<?php

namespace Ora\Chat\Interfaces;

use Illuminate\Support\MessageBag;

interface EloquentValidationInterface {

    public function setRules(array $rules, $add = false);
    public function getRules();
    public function setErrors(MessageBag $messages);
    public function getErrors();

}