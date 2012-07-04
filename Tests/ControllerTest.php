<?php
/**
 * File defining \Backend\Core\Tests\ControllerTest
 *
 * PHP Version 5.3
 *
 * @category  Backend
 * @package   CoreTests
 * @author    J Jurgens du Toit <jrgns@backend-php.net>
 * @copyright 2011 - 2012 Jade IT (cc)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @link      http://backend-php.net
 */
namespace Backend\Core\Tests;
use \Backend\Core\Controller;
use \Backend\Core\Request;
use \Backend\Core\Response;
/**
 * Class to test the \Backend\Core\Controller class
 *
 * @category Backend
 * @package  CoreTests
 * @author   J Jurgens du Toit <jrgns@backend-php.net>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://backend-php.net
 */
class ControllerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test the setters and getters for Request
     *
     * @return void
     */
    public function testRequestAccessors()
    {
        $request = new Request();
        $controller = new Controller();
        $controller->setRequest($request);
        $this->assertSame($request, $controller->getRequest());
    }

    /**
     * Test a Relative Redirect
     *
     * @return void
     */
    public function testRelativeRedirect()
    {
        $controller = new Controller();
        $response = $controller->redirect('/');
        $headers  = $response->getHeaders();
        $this->assertArrayHasKey('Location', $headers);
        $this->assertEquals('/', $headers['Location']);
    }

    /**
     * Test an Absolute Redirect
     *
     * @return void
     */
    public function testAbsoluteRedirect()
    {
        $controller = new Controller();
        $response = $controller->redirect('http://www.google.com');
        $headers  = $response->getHeaders();
        $this->assertArrayHasKey('Location', $headers);
        $this->assertEquals('http://www.google.com', $headers['Location']);
    }

    /**
     * Test a Permanent Redirect
     *
     * @return void
     */
    public function testPermanentRedirect()
    {
        $controller = new Controller();
        $response = $controller->redirect('http://www.google.com', 302);
        $headers  = $response->getHeaders();
        $this->assertArrayHasKey('Location', $headers);
        $this->assertEquals('http://www.google.com', $headers['Location']);
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Test an Invalid Redirect
     *
     * @expectedException \Backend\Core\Exception
     * @expectedExceptionMessage Invalid Redirection Response Code
     * @return void
     */
    public function testInvalidRedirect()
    {
        $controller = new Controller();
        $controller->redirect('/somewhere', 401);
    }
}
