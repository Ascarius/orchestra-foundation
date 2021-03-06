<?php namespace Orchestra\Foundation\Validation\TestCase;

use Mockery as m;
use Illuminate\Support\Facades\Facade;
use Illuminate\Container\Container;
use Orchestra\Foundation\Validation\Auth;
use Illuminate\Support\Facades\Validator;

class AuthTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        Facade::clearResolvedInstances();
        Facade::setFacadeApplication(new Container);
    }

    /**
     * Teardown the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test Orchestra\Foundation\Validation\Auth.
     *
     * @test
     */
    public function testInstance()
    {
        $stub = new Auth;

        $this->assertInstanceOf('\Orchestra\Support\Validator', $stub);
    }

    /**
     * Test Orchestra\Foundation\Validation\Auth validation.
     *
     * @test
     */
    public function testValidation()
    {
        $input = array('email' => 'admin@orchestraplatform.com', 'password' => '123');
        $rules = array('email' => array('required', 'email'));

        $factory = m::mock('\Illuminate\Validation\Factory')->makePartial();
        $validator = m::mock('\Illuminate\Validation\Validator');
        $factory->shouldReceive('make')->once()->with($input, $rules, array())->andReturn($validator);
        Validator::swap($factory);

        $stub       = new Auth;
        $validation = $stub->with($input);

        $this->assertEquals($validator, $validation);
    }

    /**
     * Test Orchestra\Foundation\Validation\Auth on login.
     *
     * @test
     */
    public function testValidationOnLogin()
    {
        $input = array('email' => 'admin@orchestraplatform.com', 'password' => '123');
        $rules = array('email' => array('required', 'email'), 'password' => array('required'));

        $factory = m::mock('\Illuminate\Validation\Factory')->makePartial();
        $validator = m::mock('\Illuminate\Validation\Validator');
        $factory->shouldReceive('make')->once()->with($input, $rules, array())->andReturn($validator);
        Validator::swap($factory);

        $stub       = new Auth;
        $validation = $stub->on('login')->with($input);

        $this->assertEquals($validator, $validation);
    }
}
