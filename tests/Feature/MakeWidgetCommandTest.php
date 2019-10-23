<?php

namespace Chargefield\LaravelWidget\Tests\Feature;

use Illuminate\Support\Facades\File;
use Chargefield\LaravelWidget\Facades\Widget;
use Chargefield\LaravelWidget\Tests\TestCase;

class MakeWidgetCommandTest extends TestCase
{
    /** @test */
    public function it_creates_the_class_and_view_for_widget()
    {
        $class = 'UserList';
        $parser = Widget::parse($class);

        $this->cleanFiles($parser);

        $this->artisan("make:widget {$class}")
            ->expectsOutput("Widget created!\n")
            ->assertExitCode(0);

        $this->assertTrue(File::exists($parser->getClassPath()));
        $this->assertTrue(File::exists($parser->getViewPath()));

        $this->cleanFiles($parser);
    }

    /** @test */
    public function it_throws_a_warning_if_files_exists()
    {
        $class = 'UserList';
        $parser = Widget::parse($class);

        $this->cleanFiles($parser);

        $this->artisan("make:widget {$class}")
            ->expectsOutput("Widget created!\n")
            ->assertExitCode(0);

        $this->assertTrue(File::exists($parser->getClassPath()));
        $this->assertTrue(File::exists($parser->getViewPath()));

        $this->artisan("make:widget {$class}")
            ->expectsOutput('Widget class already exists!')
            ->expectsOutput('Widget view already exists!')
            ->assertExitCode(0);

        $this->cleanFiles($parser);
    }
}
