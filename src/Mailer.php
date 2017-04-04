<?php

namespace Omnimail\Silverpop;

use Omnimail\Common\AbstractMailer;
use Omnimail\EmailInterface;
use Omnimail\MailerInterface;
use Omnimail\Omnimail;
use Omnimail\Silverpop\Requests\GetSentMailingsForOrgRequest;
use Omnimail\Silverpop\Requests\RawRecipientDataExportRequest;
use SilverpopConnector\SilverpopConnectorException;

/**
 * Created by IntelliJ IDEA.
 * User: emcnaughton
 * Date: 4/4/17
 * Time: 12:12 PM
 */
class Mailer extends AbstractMailer implements MailerInterface
{
    protected $username;
    protected $password;
    protected $engageServer;

  /**
   * @return mixed
   */
  public function getUsername() {
    return $this->userName;
  }

  /**
   * @param mixed $userName
   */
  public function setUsername($userName) {
    $this->userName = $userName;
  }

  /**
   * @return mixed
   */
  public function getPassword() {
    return $this->password;
  }

  /**
   * @param mixed $password
   */
  public function setPassword($password) {
    $this->password = $password;
  }

  /**
   * @return mixed
   */
  public function getEngageServer() {
    return $this->engageServer ? $this->engageServer : 4;
  }

  /**
   * @param mixed $engageServer
   */
  public function setEngageServer($engageServer) {
    $this->engageServer = $engageServer;
  }


    public function send(EmailInterface $email) {}

  /**
   * Get Mailings.
   *
   * @param array $parameters
   *
   * @return \Omnimail\Silverpop\Responses\MailingsResponse
   */
    public function getMailings($parameters) {
      $requestObject = new GetSentMailingsForOrgRequest(array(
        'username' => $this->getUsername(),
        'password' => $this->getPassword()
      ));

      $requestObject->setStartTimeStamp((strtotime(!empty($parameters['start_date']) ? $parameters['start_date'] : 'a week ago')));
      if (!empty($parameters['end_date'])) {
        $requestObject->setEndTimeStamp(strtotime($parameters['end_date']));
      }

      $mailings = $requestObject->getResponse();
      return $mailings;
    }

  /**
   * Get Mailings.
   *
   * @param array $parameters
   *
   * @return \Omnimail\Silverpop\Responses\MailingsResponse
   */
  public function getRecipients($parameters) {
    $requestObject = new RawRecipientDataExportRequest(array_merge($parameters, array(
      'username' => $this->getUsername(),
      'password' => $this->getPassword()
    )));

    $requestObject->setStartTimeStamp((strtotime(!empty($parameters['start_date']) ? $parameters['start_date'] : 'a week ago')));
    if (!empty($parameters['end_date'])) {
      $requestObject->setEndTimeStamp(strtotime($parameters['end_date']));
    }

    $recipients = $requestObject->getResponse($parameters);
    return $recipients;
  }

}
