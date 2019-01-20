<?php

namespace App\Tests\Unit\Service\Mail;

use App\Service\Mail\SwiftMailerService;
use PHPUnit\Framework\TestCase;
use Swift_Message;
use Swift_Mailer;

/**
 * Class SwiftMailerServiceTest
 * @package App\Tests\Service
 */
class SwiftMailerServiceTest extends TestCase
{
    public function testSetSubject()
    {
        $subject = 'Hello World';
        $mockMailer = $this->createMock(Swift_Mailer::class);
        $mockMessage = $this->createMock(Swift_Message::class);

        $mockMessage
            ->expects($this->once())
            ->method('setSubject')
            ->with($subject);

        $service = new SwiftMailerService($mockMailer, $mockMessage);

        $actual = $service->setSubject($subject);
        $this->assertInstanceOf(SwiftMailerService::class, $actual);
    }

    /**
     * @test setFrom
     */
    public function setFromWithAddressAndNoName()
    {
        $address = 'lucy_mcclain@test.com';
        $mockMailer = $this->createMock(Swift_Mailer::class);
        $mockMessage = $this->createMock(Swift_Message::class);

        $mockMessage
            ->expects($this->once())
            ->method('setFrom')
            ->with($address, null);

        $service = new SwiftMailerService($mockMailer, $mockMessage);

        $actual = $service->setFrom($address);
        $this->assertInstanceOf(SwiftMailerService::class, $actual);
    }

    /**
     * @test setFrom
     */
    public function setFromWithArrayOfAddressesAndNoName()
    {
        $addresses = ['lucy_mcclain@test.com', 'john_mcclain@test.com'];
        $mockMailer = $this->createMock(Swift_Mailer::class);
        $mockMessage = $this->createMock(Swift_Message::class);

        $mockMessage
            ->expects($this->once())
            ->method('setFrom')
            ->with($addresses, null);

        $service = new SwiftMailerService($mockMailer, $mockMessage);

        $actual = $service->setFrom($addresses);
        $this->assertInstanceOf(SwiftMailerService::class, $actual);
    }

    /**
     * @test setFrom
     */
    public function setFromWithAddressAndName()
    {
        $address = 'lucy_mcclain@test.com';
        $name = 'Lucy';

        $mockMailer = $this->createMock(Swift_Mailer::class);
        $mockMessage = $this->createMock(Swift_Message::class);

        $mockMessage
            ->expects($this->once())
            ->method('setFrom')
            ->with($address, $name);

        $service = new SwiftMailerService($mockMailer, $mockMessage);

        $actual = $service->setFrom($address, $name);
        $this->assertInstanceOf(SwiftMailerService::class, $actual);
    }

    /**
     * @test setFrom
     */
    public function setFromWithArrayOfAddressesAndNames()
    {
        $addresses = [
            'lucy_mcclain@test.com' => 'Lucy McClain',
            'john_mcclain@test.com' => 'John McClain',
        ];
        $mockMailer = $this->createMock(Swift_Mailer::class);
        $mockMessage = $this->createMock(Swift_Message::class);

        $mockMessage
            ->expects($this->once())
            ->method('setFrom')
            ->with($addresses, null);

        $service = new SwiftMailerService($mockMailer, $mockMessage);

        $actual = $service->setFrom($addresses);
        $this->assertInstanceOf(SwiftMailerService::class, $actual);
    }

    /**
     * @test setTo
     */
    public function setToWithAddressAndNoName()
    {
        $address = 'lucy_mcclain@test.com';
        $mockMailer = $this->createMock(Swift_Mailer::class);
        $mockMessage = $this->createMock(Swift_Message::class);

        $mockMessage
            ->expects($this->once())
            ->method('setTo')
            ->with($address, null);

        $service = new SwiftMailerService($mockMailer, $mockMessage);

        $actual = $service->setTo($address);
        $this->assertInstanceOf(SwiftMailerService::class, $actual);
    }

    /**
 * @test setTo
 */
    public function setToWithAddressAndName()
    {
        $address = 'lucy_mcclain@test.com';
        $name = 'Lucy McClain';
        $mockMailer = $this->createMock(Swift_Mailer::class);
        $mockMessage = $this->createMock(Swift_Message::class);

        $mockMessage
            ->expects($this->once())
            ->method('setTo')
            ->with($address, $name);

        $service = new SwiftMailerService($mockMailer, $mockMessage);

        $actual = $service->setTo($address, $name);
        $this->assertInstanceOf(SwiftMailerService::class, $actual);
    }

    /**
     * @test setTo
     */
    public function setToWithArrayOfAddresses()
    {
        $addresses = [
            'lucy_mcclain@test.com' => 'Lucy McClain',
            'john_mcclain@test.com' => 'John McClain',
        ];
        $mockMailer = $this->createMock(Swift_Mailer::class);
        $mockMessage = $this->createMock(Swift_Message::class);

        $mockMessage
            ->expects($this->once())
            ->method('setTo')
            ->with($addresses, null);

        $service = new SwiftMailerService($mockMailer, $mockMessage);

        $actual = $service->setTo($addresses);
        $this->assertInstanceOf(SwiftMailerService::class, $actual);
    }
}
