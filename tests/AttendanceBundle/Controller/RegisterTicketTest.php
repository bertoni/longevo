<?php

namespace AttendanceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterTicketTest extends WebTestCase
{
    protected static $container;
    protected static $em;
    private $route = 'attendance_homepage';
    
    
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
    
        $this->assertEquals('AttendanceBundle\Controller\DefaultController::indexAction', $client->getRequest()->attributes->get('_controller'));
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

        $this->assertEquals(1, $crawler->filter('html:contains("Novo Chamado")')->count());
        $this->assertEquals(1, $crawler->filter('input[type="text"][name="name"]')->count());
        $this->assertEquals(1, $crawler->filter('input[type="email"][name="email"]')->count());
        $this->assertEquals(1, $crawler->filter('input[type="text"][name="order_id"]')->count());
        $this->assertEquals(1, $crawler->filter('input[type="text"][name="title"]')->count());
        $this->assertEquals(1, $crawler->filter('textarea[name="observation"]')->count());
        $this->assertEquals(1, $crawler->filter('button[type="submit"]')->count());
    }

    public function testCreateWithoutInformName()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', self::$container->get('router')->generate($this->route));
        
        $form = $crawler->filter('form#addticket')->form();
        $client->submit($form);
        
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        
        $json_return = json_decode($client->getResponse()->getContent());
        $this->assertArrayHasKey('message', (array)$json_return);
        
        $this->assertEquals('Nome obrigatório', $json_return->message);
    }

    public function testCreateWithoutInformEmail()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', self::$container->get('router')->generate($this->route));
    
        $form         = $crawler->filter('form#addticket')->form();
        $form['name'] = 'Bla bla bla';
        $client->submit($form);
    
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    
        $json_return = json_decode($client->getResponse()->getContent());
        $this->assertArrayHasKey('message', (array)$json_return);
    
        $this->assertEquals('Email obrigatório', $json_return->message);
    }

    public function testCreateWithoutInformOrderId()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', self::$container->get('router')->generate($this->route));
    
        $form          = $crawler->filter('form#addticket')->form();
        $form['name']  = 'Bla bla bla';
        $form['email'] = 'test@gmail.com';
        $client->submit($form);
    
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    
        $json_return = json_decode($client->getResponse()->getContent());
        $this->assertArrayHasKey('message', (array)$json_return);
    
        $this->assertEquals('Número do Pedido obrigatório', $json_return->message);
    }

    public function testCreateWithoutInformTitle()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', self::$container->get('router')->generate($this->route));
    
        $form             = $crawler->filter('form#addticket')->form();
        $form['name']     = 'Bla bla bla';
        $form['email']    = 'test@gmail.com';
        $form['order_id'] = 1;
        $client->submit($form);
    
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    
        $json_return = json_decode($client->getResponse()->getContent());
        $this->assertArrayHasKey('message', (array)$json_return);
    
        $this->assertEquals('Título obrigatório', $json_return->message);
    }

    public function testCreateWithoutInformObservation()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', self::$container->get('router')->generate($this->route));
    
        $form             = $crawler->filter('form#addticket')->form();
        $form['name']     = 'Bla bla bla';
        $form['email']    = 'test@gmail.com';
        $form['order_id'] = 1;
        $form['title']    = 'Bla bla bla';
        $client->submit($form);
    
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    
        $json_return = json_decode($client->getResponse()->getContent());
        $this->assertArrayHasKey('message', (array)$json_return);
    
        $this->assertEquals('Observação obrigatória', $json_return->message);
    }

    public function testCreateInformInvalidOrderId()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', self::$container->get('router')->generate($this->route));
    
        $form                = $crawler->filter('form#addticket')->form();
        $form['name']        = 'Bla bla bla';
        $form['email']       = 'test@gmail.com';
        $form['order_id']    = 0;
        $form['title']       = 'Bla bla bla';
        $form['observation'] = 'Bla bla bla';
        $client->submit($form);
    
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    
        $json_return = json_decode($client->getResponse()->getContent());
        $this->assertArrayHasKey('message', (array)$json_return);
    
        $this->assertEquals('Pedido não encontrado', $json_return->message);
    }

    public function testCreateWithSuccess()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', self::$container->get('router')->generate($this->route));
        
        $Orders = self::$em->getRepository('AttendanceBundle:Order')
            ->findBy(array(), array('id' => 'DESC'), 1, 0);
    
        $form                = $crawler->filter('form#addticket')->form();
        $form['name']        = 'Bla bla bla';
        $form['email']       = 'test@gmail.com';
        $form['order_id']    = $Orders[0]->getId();
        $form['title']       = 'Bla bla bla';
        $form['observation'] = 'Bla bla bla';
        $client->submit($form);
    
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    
        $json_return = json_decode($client->getResponse()->getContent());
        $this->assertArrayHasKey('message', (array)$json_return);
    
        $this->assertEquals('Chamado criado com sucesso!', $json_return->message);
    }
}
