<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tetranybles\ServerConfiguration\Nginx;
use Tetranybles\ServerConfiguration\NginxConfiguration;

class ServerBlockTest extends TestCase{
    /** @test */
    function it_loads_a_server_block(){

        $server = __DIR__ . '/stubs/server.conf';
        $block = Nginx::load($server);
        $this->assertStringContainsString('server',
            $block);
    }

    /** @test */
    function it_can_convert_to_an_array_of_lines(){
        $server = __DIR__ . '/stubs/server.conf';
        $this->assertCount(21,Nginx::load($server)->lines());
    }

    /** @test */
    function it_discards_irrelevant_lines_from_the_server_block(){
        $server = __DIR__ . '/stubs/server.conf';
        $this->assertStringNotContainsString('web',
            Nginx::load($server));
    }
    /** @test */
    function it_should_set_server_block_directive(){
        $server = __DIR__ . '/stubs/server.conf';
        $nginx = Nginx::load($server)->lines();


        $block = NginxConfiguration::load($server)->setDirective(['/var/www/html/markitti/public'], ['/var/www/html/hello/public'])
            ->setDirective(['markitti.com', 'www.markitti.com'], ['hello.com', 'www.hello.com']);

        $this->assertStringContainsString('hello.com www.hello.co', $block);
        $this->assertStringContainsString( '/var/www/html/hello/public', $block);

    }

}