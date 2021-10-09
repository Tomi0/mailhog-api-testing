<?php


namespace Tests\Mailhog;


use GuzzleHttp\Exception\GuzzleException;
use Mailhog\MailhogTesting;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Tests\TestCase;

class MailhogTestingTest extends TestCase
{
    use MailhogTesting;

    /**
     * @throws GuzzleException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpMailhogEnviroment('localhost', 1025, 8025);
        $this->clearInbox();
    }

    /**
     * @throws Exception
     */
    private function sendMail($to, string $subject, string $message): void
    {
        $mail = new PHPMailer(true);
        $this->setPhpMailerConfiguration($mail);

        if (is_array($to)){
            foreach ($to as $i)
                $mail->addAddress($i);
        } else {
            $mail->addAddress($to);
        }

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
    }

    /**
     * @param PHPMailer $PHPMailer
     * @throws Exception
     */
    private function setPhpMailerConfiguration(PHPMailer $PHPMailer): void
    {
        $PHPMailer->isSMTP();
        $PHPMailer->Host = $this->host;
        $PHPMailer->Port = $this->mailPort;
        $PHPMailer->setFrom('mailhogTesting@testing.test', 'Mailhog testing');
    }


    public function testEnviromentVariablesAreSetCorrectly(): void
    {
        $expectedMailPort = 1025;
        $expectedWebPort = 8025;
        $expectedHost = '127.0.0.1';
        $expectedSsl = true;
        $this->setUpMailhogEnviroment($expectedHost, $expectedMailPort, $expectedWebPort, $expectedSsl);

        $this->assertEquals($expectedMailPort, $this->mailPort);
        $this->assertEquals($expectedWebPort, $this->apiPort);
        $this->assertEquals($expectedHost, $this->host);
        $this->assertEquals($expectedSsl, $this->ssl);
    }

    /**
     * @throws Exception
     */
    public function testMessageExistsByContent(): void
    {
        $this->sendMail('test@test.test', 'Email subject', 'This is the message of the email');

        $this->assertTrue($this->messageExistsByContent('This is the messa'));
    }

    /**
     * @throws Exception
     */
    public function testMessageDoesNotExistByContent(): void
    {
        $this->sendMail('test@test.test', 'Email subject', 'This is the message of the email');

        $this->assertFalse($this->messageExistsByContent('This is the message does not exist'));
    }

    /**
     */
    public function testFailMailhogApi(): void
    {
        // TODO
        $this->assertTrue(true);
    }

    /**
     * @throws Exception
     * @throws GuzzleException
     */
    public function testGetAllMessages(): void
    {
        $this->sendMail('test1@test.test', 'Email subject1', 'This is the message of the email 1');
        $this->sendMail('test2@test.test', 'Email subject2', 'This is the message of the email 2');
        $this->sendMail('test3@test.test', 'Email subject3', 'This is the message of the email 3');

        $result = $this->getAllMessages();

        $this->assertEquals('Email subject3', $result[0]->getSubject());
        $this->assertEquals('Email subject2', $result[1]->getSubject());
        $this->assertEquals('Email subject1', $result[2]->getSubject());
    }

    public function testClearInbox(): void
    {
        $this->sendMail('test1@test.test', 'Email subject1', 'This is the message of the email 1');
        $this->sendMail('test2@test.test', 'Email subject2', 'This is the message of the email 2');
        $this->sendMail('test3@test.test', 'Email subject3', 'This is the message of the email 3');

        $this->assertTrue(true);
    }
}