<?php

namespace AttendanceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ListTicketTest extends WebTestCase
{
    protected static $container;
    protected static $em;
    private $route = 'attendance_report';
    
    
    /**
     * {@inheritDoc}
     */
    public static function setUpBeforeClass()
    {
        self::bootKernel();
    
        self::$container = static::$kernel->getContainer();
        if (is_null(self::$em)) {
            self::$em = static::$kernel->getContainer()
                ->get('doctrine')
                ->getManager();
        }
    }

    public function testAssertController()
    {
        $client = static::createClient();
        $client->request('GET', self::$container->get('router')->generate($this->route));
    
        $this->assertEquals('AttendanceBundle\Controller\DefaultController::listAction', $client->getRequest()->attributes->get('_controller'));
    }
    
    public function test200ForLoginPage()
    {
        $client = static::createClient();
        $client->request('GET', self::$container->get('router')->generate($this->route));
    
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function testHtmlElements()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', self::$container->get('router')->generate($this->route));
    
        $this->assertEquals(1, $crawler->filter('html:contains("Relatório de Chamado")')->count());
        $this->assertEquals(1, $crawler->filter('input[type="email"][name="email"]')->count());
        $this->assertEquals(1, $crawler->filter('input[type="text"][name="order_id"]')->count());
        $this->assertEquals(1, $crawler->filter('button[type="submit"]')->count());
        $this->assertEquals(1, $crawler->filter('a[href="2"]')->count());
        
    }
}