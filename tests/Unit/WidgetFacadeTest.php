<?php

namespace Chargefield\LaravelWidget\Tests\Unit;

use Chargefield\LaravelWidget\WidgetParser;
use Chargefield\LaravelWidget\Facades\Widget;
use Chargefield\LaravelWidget\Tests\TestCase;

class WidgetFacadeTest extends TestCase
{
    /** @test */
    public function it_gets_the_root_namespace()
    {
        $this->assertEquals(
            'App\\Http\\Widgets',
            Widget::getRootNamespace()
        );
    }

    /** @test */
    public function it_gets_the_root_view()
    {
        $this->assertEquals(
            'widgets',
            Widget::getRootView()
        );
    }

    /** @test */
    public function it_gets_an_instance_of_widget_parser()
    {
        $parser = Widget::parse('UserList');

        $this->assertInstanceOf(WidgetParser::class, $parser);
        $this->assertEquals('widgets.user-list', $parser->getViewName());
        $this->assertEquals(resource_path('views/widgets/user-list.blade.php'), $parser->getViewPath());
        $this->assertEquals('App\\Http\\Widgets\\UserList', $parser->getFullClassName());
        $this->assertEquals(app_path('Http/Widgets/UserList.php'), $parser->getClassPath());

        $template = file_get_contents(__DIR__.'/../../src/Stubs/Widget.stub');

        $this->assertEquals(
            preg_replace_array(
                ['/\[namespace\]/', '/\[class\]/'],
                ['App\\Http\\Widgets', 'UserList'],
                $template
            ),
            $parser->getClassContents()
        );
    }
}
