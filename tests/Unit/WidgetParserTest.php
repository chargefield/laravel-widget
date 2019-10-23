<?php

namespace Chargefield\LaravelWidget\Tests\Unit;

use Chargefield\LaravelWidget\WidgetParser;
use Chargefield\LaravelWidget\Tests\TestCase;

class WidgetParserTest extends TestCase
{
    /** @test */
    public function it_returns_a_widget_parser_object_with_helper_methods()
    {
        $parser = new WidgetParser('UserList', 'App\\Http\\Widgets');

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
