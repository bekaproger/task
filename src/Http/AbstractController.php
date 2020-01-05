<?php

namespace Lil\Http;

use Doctrine\ORM\EntityManager;

abstract class AbstractController
{
    public function getManager(): EntityManager
    {
        return app()->get('doctrine_manager');
    }

    public function validate(Request $request, AbstractValidator $validator)
    {
        $exceptions = Validation::validate($request, $validator);

        if (!empty($exceptions)) {
            $request->setRequestSessionData(1, ['errors' => $exceptions]);
            throw new ValidationException();
        }
    }
}
