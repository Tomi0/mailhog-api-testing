<?php


namespace Tests\Mailhog;


use Mailhog\MailhogTesting;
use PHPMailer\PHPMailer\PHPMailer;
use Tests\TestCase;

class MailhogTestingTest extends TestCase
{
    use MailhogTesting;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpMailhogEnviroment('localhost', 1025, 8025);
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
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
     * @throws \PHPMailer\PHPMailer\Exception
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
        $this->setUpMailhogEnviroment($expectedHost, $expectedMailPort, $expectedWebPort);

        $this->assertEquals($expectedMailPort, $this->mailPort);
        $this->assertEquals($expectedWebPort, $this->apiPort);
        $this->assertEquals($expectedHost, $this->host);
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function testMessageExistsByContent(): void
    {
        $this->sendMail('test@test.test', 'Email subject', 'This is the message of the email');

        $this->assertTrue($this->messageExistsByContent('This is the messa'));
    }
}