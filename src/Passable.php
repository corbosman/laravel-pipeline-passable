<?php

namespace CorBosman\Pipeline;

use Illuminate\Pipeline\Pipeline;
use Spatie\DataTransferObject\DataTransferObject;

abstract class Passable extends DataTransferObject implements PassableContract
{
    /**
     * send this passable through a pipeline
     *
     * @param $pipes
     * @param string $via
     * @return mixed
     */
    public function pipeline($pipes, $via = 'handle')
    {
        return app(Pipeline::class)
            ->send($this)
            ->through($pipes)
            ->via($via)
            ->then(function ($passable) {
                return $passable->return();
            });
    }

    /**
     * By default just return the passable, but the parent class can override
     *
     * @return mixed
     */
    public function return()
    {
        return $this;
    }
}
