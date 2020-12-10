<?php

namespace CorBosman\Pipeline\Tests;

use CorBosman\Pipeline\Passable;
use Orchestra\Testbench\TestCase;
use CorBosman\Pipeline\Tests\Passables\MyPassable;
use CorBosman\Pipeline\Tests\Pipelines\ReverseInvokable;
use CorBosman\Pipeline\Tests\Pipelines\UppercaseWithFilter;
use CorBosman\Pipeline\Tests\Pipelines\UppercaseWithHandle;
use Spatie\DataTransferObject\DataTransferObject;

class PassableTest extends TestCase
{
    public function test_it_can_instantiate_a_passable()
    {
        $passable = new MyPassable(['input' => 'input', 'output' => 'output']);

        $this->assertInstanceOf(Passable::class, $passable);
        $this->assertInstanceOf(DataTransferObject::class, $passable);
    }

    public function test_it_can_send_a_passable_through_a_pipeline()
    {
        $passable = new MyPassable(['input' => 'input', 'output' => 'output']);

        $response = $passable->pipeline([UppercaseWithHandle::class, ReverseInvokable::class]);

        $this->assertEquals('TUPTUO', $response);
    }

    public function test_it_can_change_the_pipeline_class_method()
    {
        $passable = new MyPassable(['input' => 'input', 'output' => 'output']);

        $response = $passable->pipeline([UppercaseWithFilter::class], 'filter');

        $this->assertEquals('OUTPUT', $response);
    }
}
