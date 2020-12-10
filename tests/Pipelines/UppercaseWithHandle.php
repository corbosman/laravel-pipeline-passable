<?php

namespace CorBosman\Pipeline\Tests\Pipelines;

use CorBosman\Pipeline\Tests\Passables\MyPassable;

class UppercaseWithHandle
{
    public function handle(MyPassable $passable, $next)
    {
        $passable->output = strtoupper($passable->output);

        return $next($passable);
    }
}
