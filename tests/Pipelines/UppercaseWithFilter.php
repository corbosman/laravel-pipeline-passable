<?php

namespace CorBosman\Pipeline\Tests\Pipelines;

use CorBosman\Pipeline\Tests\Passables\MyPassable;

class UppercaseWithFilter
{
    public function filter(MyPassable $passable, $next)
    {
        $passable->output = strtoupper($passable->output);

        return $next($passable);
    }
}
