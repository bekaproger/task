<?php

namespace Lil\Http;

class Validation implements ValidationInterface
{
    public static function validate(Request $request, AbstractValidator $validator)
    {
        $error_messages = [];

        $rules = $validator->handle($request);

        foreach ($rules as $key => $rule) {
            $param = $request->request->get($key, null);
            if (!is_callable($rule)) {
                throw new \Exception("Rule for parameter $key in ".get_class($validator).' must be callable.');
            }

            $res = $rule($param);

            if (false === $res) {
                $error_messages[$key] = self::getErrorMessage($validator, $key);
            }
        }

        return $error_messages;
    }

    private static function getErrorMessage(AbstractValidator $validator, $key)
    {
        if (array_key_exists($key, $validator->messages())) {
            return $validator->messages()[$key];
        }

        return "Invalid $key parameter";
    }
}
