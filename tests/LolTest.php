<?php
namespace Free\Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

	 /** 
     * Basic, application-wide functional test inspired by Symfony best practices.
     * Simply checks that all application URLs load successfully.
     * During test execution, this method is called for each URL returned by the provideUrls method.
     *
     * @dataProvider provideUrls 
     */
    public function testPageIsSuccessful($url)
    {
        $client = $this->createClient();
      
        $client->request('GET',$url,["id"=>0,"name"=>"Blog2"]);
        $this->assertTrue($client->getResponse()->headers->contains(
        'Content-Type',
        'application/json'
    ),
    'the "Content-Type" header is "application/json"' );
    }
        public function provideUrls()
    {
        return array(
        	//Test 
            array('/api/delete'),
            array('/api/add'),

            ); 
    }
}
