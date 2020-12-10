<?php

namespace CorBosman\Pipeline\Tests\Pipelines;

use CorBosman\Pipeline\Tests\Passables\MyPassable;

class ReverseInvokable
{
    public function __invoke(MyPassable $passable, $next)
    {
        $passable->output = strrev($passable->output);

        return $next($passable);
    }
}
