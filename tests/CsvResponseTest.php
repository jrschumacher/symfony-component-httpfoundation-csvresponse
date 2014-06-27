<?php

namespace Symfony\Component\HttpFoundation\Tests;

use Symfony\Component\HttpFoundation\CsvResponse;
use Goodby\CSV\Export\Standard\Exporter;
use Goodby\CSV\Export\Standard\ExporterConfig;

class CsvResponseTest extends \PHPUnit_Framework_TestCase
{
    /*public function testConstructorEmpty()
    {
        $response = new CsvResponse();
        $this->assertSame(false, $response->getContent());
    }*/

    public function testConstructorWithArray()
    {
        $response = new CsvResponse(array(
            array('1', 'alice', 'alice@example.com'),
            array('2', 'bob', 'bob@example.com'),
            array('3', 'carol', 'carol@example.com'),
        ));

        ob_start();
        $response->sendContent();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertContains("1,alice,alice@example.com", $content);
        $this->assertContains("2,bob,bob@example.com", $content);
        $this->assertContains("3,carol,carol@example.com", $content);
    }

    public function testConstructorWithCustomStatus()
    {
        $response = new CsvResponse(array(), 202);
        $this->assertSame(202, $response->getStatusCode());
    }

    public function testConstructorAddsContentTypeHeader()
    {
        $response = new CsvResponse();
        $this->assertSame('text/csv', $response->headers->get('Content-Type'));
    }

    public function testConstructorWithCustomHeaders()
    {
        $response = new CsvResponse(array(), 200, array('ETag' => 'foo'));
        $this->assertSame('text/csv', $response->headers->get('Content-Type'));
        $this->assertSame('foo', $response->headers->get('ETag'));
    }

    public function testConstructorWithCustomContentType()
    {
        $headers = array('Content-Type' => 'application/vnd.acme.blog-v1+text');

        $response = new CsvResponse(array(), 200, $headers);
        $this->assertSame('application/vnd.acme.blog-v1+text', $response->headers->get('Content-Type'));
    }

    public function testConstructorWithGetExporterConfig()
    {
        $response = new CsvResponse(array(
            array('1', 'alice', 'alice@example.com'),
            array('2', 'bob', 'bob@example.com'),
            array('3', 'carol', 'carol@example.com'),
        ));

        $config = $response->getExporterConfig();
        $config->setDelimiter("\t");

        ob_start();
        $response->sendContent();
        $content = ob_get_contents();
        ob_end_clean();
        
        $this->assertContains("1\talice\talice@example.com", $content);
        $this->assertContains("2\tbob\tbob@example.com", $content);
        $this->assertContains("3\tcarol\tcarol@example.com", $content);
    }


    public function testConstructorWithSetExporterConfig()
    {
        $response = new CsvResponse(array(
            array('1', 'alice', 'alice@example.com'),
            array('2', 'bob', 'bob@example.com'),
            array('3', 'carol', 'carol@example.com'),
        ));

        $config = new ExporterConfig();
        $config->setDelimiter("\t");
        $response->setExporterConfig($config);

        ob_start();
        $response->sendContent();
        $content = ob_get_contents();
        ob_end_clean();
        
        $this->assertContains("1\talice\talice@example.com", $content);
        $this->assertContains("2\tbob\tbob@example.com", $content);
        $this->assertContains("3\tcarol\tcarol@example.com", $content);
    }

    public function testCreate()
    {
        $response = CsvResponse::create(array(
            array('1', 'alice', 'alice@example.com'),
            array('2', 'bob', 'bob@example.com'),
            array('3', 'carol', 'carol@example.com'),
        ), 204);

        ob_start();
        $response->sendContent();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\CsvResponse', $response);
        $this->assertContains("1,alice,alice@example.com", $content);
        $this->assertContains("2,bob,bob@example.com", $content);
        $this->assertContains("3,carol,carol@example.com", $content);
        $this->assertEquals(204, $response->getStatusCode());
    }

    public function testStaticCreateWithCustomStatus()
    {
        $response = CsvResponse::create(array(), 202);
        $this->assertSame(202, $response->getStatusCode());
    }

    public function testStaticCreateAddsContentTypeHeader()
    {
        $response = CsvResponse::create();
        $this->assertSame('text/csv', $response->headers->get('Content-Type'));
    }

    public function testStaticCreateWithCustomHeaders()
    {
        $response = CsvResponse::create(array(), 200, array('ETag' => 'foo'));
        $this->assertSame('text/csv', $response->headers->get('Content-Type'));
        $this->assertSame('foo', $response->headers->get('ETag'));
    }

    public function testStaticCreateWithCustomContentType()
    {
        $headers = array('Content-Type' => 'application/vnd.acme.blog-v1+csv');

        $response = CsvResponse::create(array(), 200, $headers);
        $this->assertSame('application/vnd.acme.blog-v1+csv', $response->headers->get('Content-Type'));
    }


    public function testStaticCreateWithGetExporterConfig()
    {
        $response = CsvResponse::create(array(
            array('1', 'alice', 'alice@example.com'),
            array('2', 'bob', 'bob@example.com'),
            array('3', 'carol', 'carol@example.com'),
        ));

        $config = $response->getExporterConfig();
        $config->setDelimiter("\t");

        ob_start();
        $response->sendContent();
        $content = ob_get_contents();
        ob_end_clean();
        
        $this->assertContains("1\talice\talice@example.com", $content);
        $this->assertContains("2\tbob\tbob@example.com", $content);
        $this->assertContains("3\tcarol\tcarol@example.com", $content);
    }


    public function testStaticCreateWithSetExporterConfig()
    {
        $response = CsvResponse::create(array(
            array('1', 'alice', 'alice@example.com'),
            array('2', 'bob', 'bob@example.com'),
            array('3', 'carol', 'carol@example.com'),
        ));

        $config = new ExporterConfig();
        $config->setDelimiter("\t");
        $response->setExporterConfig($config);

        ob_start();
        $response->sendContent();
        $content = ob_get_contents();
        ob_end_clean();
        
        $this->assertContains("1\talice\talice@example.com", $content);
        $this->assertContains("2\tbob\tbob@example.com", $content);
        $this->assertContains("3\tcarol\tcarol@example.com", $content);
    }

    public function testSetCallback()
    {
        $response = CsvResponse::create(array(
            array('0', '----', '----@example.com'),
            array('0', '----', '----@example.com'),
            array('0', '----', '----@example.com'),
        ));
        $response->setCallback(
            function() {
                $config = new ExporterConfig();
                $exporter = new Exporter($config);

                $exporter->export('php://output', array(
                    array('1', 'alice', 'alice@example.com'),
                    array('2', 'bob', 'bob@example.com'),
                    array('3', 'carol', 'carol@example.com'),
                ));
            }
        );

        ob_start();
        $response->sendContent();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertContains("1,alice,alice@example.com", $content);
        $this->assertContains("2,bob,bob@example.com", $content);
        $this->assertContains("3,carol,carol@example.com", $content);
    }

}