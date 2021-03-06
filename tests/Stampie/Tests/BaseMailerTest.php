<?php

namespace Stampie\Tests;

abstract class BaseMailerTest extends \PHPUnit_Framework_TestCase
{
    protected $adapter;

    /**
     * @var \Stampie\MailerInterface
     */
    protected $mailer;

    public function setUp()
    {
        $this->adapter = $this->getMock('Stampie\Adapter\AdapterInterface');
    }

    protected function getResponseMock($statusCode, array $content)
    {
        $response = $this->getMock('Stampie\Adapter\ResponseInterface');
        $response
            ->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue($statusCode))
        ;

        $response
            ->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue(json_encode($content)))
        ;

        return $response;
    }

    protected function getMessageMock($from, $to, $subject, $html = null, $text = null, array $headers = array())
    {
        $message = $this->getMock('Stampie\MessageInterface');

        $this->configureMessageMock($message, $from, $to, $subject, $html, $text, $headers);

        return $message;
    }

    protected function getTaggableMessageMock($from, $to, $subject, $html = null, $text = null, array $headers = array(), $tags = array())
    {
        $message = $this->getMock('Stampie\Tests\Mailer\TaggableMessage');

        $this->configureMessageMock($message, $from, $to, $subject, $html, $text, $headers);

        $message
            ->expects($this->any())
            ->method('getTag')
            ->will($this->returnValue($tags))
        ;

        return $message;
    }

    protected function getMetadataAwareMessageMock($from, $to, $subject, $html = null, $text = null, array $headers = array(), array $metadata = array())
    {
        $message = $this->getMock('Stampie\Tests\Mailer\MetadataAwareMessage');

        $this->configureMessageMock($message, $from, $to, $subject, $html, $text, $headers);

        $message
            ->expects($this->any())
            ->method('getMetadata')
            ->will($this->returnValue($metadata))
        ;

        return $message;
    }

    private function configureMessageMock(\PHPUnit_Framework_MockObject_MockObject $message, $from, $to, $subject, $html = null, $text = null, array $headers = array())
    {
        $message
            ->expects($this->any())
            ->method('getFrom')
            ->will($this->returnValue($from))
        ;

        $message
            ->expects($this->any())
            ->method('getTo')
            ->will($this->returnValue($to))
        ;

        $message
            ->expects($this->any())
            ->method('getSubject')
            ->will($this->returnValue($subject))
        ;

        $message
            ->expects($this->any())
            ->method('getHtml')
            ->will($this->returnValue($html))
        ;

        $message
            ->expects($this->any())
            ->method('getText')
            ->will($this->returnValue($text))
        ;

        $message
            ->expects($this->any())
            ->method('getHeaders')
            ->will($this->returnValue($headers))
        ;
    }
}
