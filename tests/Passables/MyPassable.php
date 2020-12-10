<?php

namespace CorBosman\Pipeline\Tests\Passables;

use CorBosman\Pipeline\Passable;

class MyPassable extends Passable
{
    public string $input;
    public string $output;

    public function return()
    {
        return $this->output;
    }
}
