<?php

namespace Chargefield\LaravelWidget\Tests\Unit;

use Illuminate\Support\Facades\File;
use Chargefield\LaravelWidget\Facades\Widget;
use Chargefield\LaravelWidget\Tests\TestCase;
use Chargefield\LaravelWidget\Tests\Fixtures\User;

class WidgetTest extends TestCase
{
    /** @test */
    public function it_checks_that_all_public_properties_and_methods_are_returned_to_the_view()
    {
        $users = factory(User::class, 5)->create();

        Widget::fake();

        $class = 'UsersWidget';

        $parser = Widget::parse($class);

        $this->cleanFiles($parser);

        $this->artisan("make:widget {$class}");

        $this->assertTrue(File::exists($parser->getClassPath()));
        $this->assertTrue(File::exists($parser->getViewPath()));

        $widget = new \App\Http\Widgets\UsersWidget;

        $this->assertEquals('All Users', $widget->title);
        $this->assertCount(5, $widget->users());
        $this->assertEquals($users->toArray(), $widget->users()->toArray());

        $view = $widget->render();

        $this->assertInstanceOf(\Illuminate\View\View::class, $view);

        $view_data = $view->gatherData();

        $this->assertEquals($users->toArray(), $view_data['users']->toArray());
        $this->assertArrayHasKey('title', $view_data);
        $this->assertArrayHasKey('users', $view_data);
        $this->assertArrayNotHasKey('accounts', $view_data);
        $this->assertArrayNotHasKey('count', $view_data);
        $this->assertEquals('All Users', $view_data['title']);
        $this->assertCount(5, $view_data['users']);

        $this->cleanFiles($parser);
    }
}
