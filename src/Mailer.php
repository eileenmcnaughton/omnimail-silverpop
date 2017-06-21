<?php

namespace Omnimail\Silverpop;

use Omnimail\Silverpop\Requests\GetSentMailingsForOrgRequest;
use Omnimail\Silverpop\Requests\RawRecipientDataExportRequest;
use Omnimail\MailerInterface;
use Omnimail\Silverpop\Requests\RequestInterface;
use Omnimail\Silverpop\Responses\ResponseInterface;
use Omnimail\Silverpop\Responses\Offline\OfflineMailingsResponse;

/**
 * Created by IntelliJ IDEA.
 * User: emcnaughton
 * Date: 4/4/17
 * Time: 12:12 PM
 */
class Mailer implements MailerInterface
{
    protected $username;
    protected $password;
    protected $engageServer;

  /**
   * Guzzle client, overridable with mock object in tests.
   *
   * @var \GuzzleHttp\Client
   */
    protected $client;

  /**
   * @return \GuzzleHttp\Client
   */
  public function getClient() {
    return $this->client;
  }

  /**
   * @param \GuzzleHttp\Client $client
   */
  public function setClient($client) {
    $this->client = $client;
  }

  /**
   * @return mixed
   */
  public function getUsername() {
    return $this->username;
  }

  /**
   * @param mixed $userName
   */
  public function setUsername($userName) {
    $this->username = $userName;
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

  public function send(\Omnimail\EmailInterface $email) {}

    /**
     * Get an array of the credential fields that are required.
     *
     * @return array
     */
    public function getCredentialFields() {
      return array(
        'username' => array('type' => 'String', 'required' => TRUE),
        'password' => array('type' => 'String', 'required' => TRUE),
        'engage_server' => array('type' => 'String', 'required' => FALSE, 'default' => 4),
      );
    }

  /**
   * Get Mailings.
   *
   * @param array $parameters
   *
   * @return \Omnimail\Silverpop\Requests\SilverpopBaseRequest
   */
    public function getMailings($parameters = array()) {
      return $this->createRequest('GetSentMailingsForOrgRequest', array_merge($parameters, array(
        'username' => $this->getUsername(),
        'password' => $this->getPassword(),
        'client' => $this->getClient(),
      )));
    }

  /**
   * Get Mailings.
   *
   * @param array $parameters
   *
   * @return \Omnimail\Silverpop\Requests\SilverpopBaseRequest
   */
  public function getRecipients($parameters = array()) {
    return $this->createRequest('RawRecipientDataExportRequest', array_merge($parameters, array(
      'username' => $this->getUsername(),
      'password' => $this->getPassword(),
      'client' => $this->getClient(),
    )));
  }

  /**
   * Initialize a request object
   *
   * This function is usually used to initialise objects of type
   * BaseRequest (or a non-abstract subclass of it)
   * using existing parameters from this gateway.
   *
   * If a client has been set on this class it will passed through,
   * allowing a mock guzzle client to be used for testing.
   *
   * Example:
   *
   * <code>
   *   function myRequest($parameters) {
   *     $this->createRequest('MyRequest', $parameters);
   *   }
   *   class MyRequest extends SilverpopBaseRequest {};
   *
   *   // Create the mailer
   *   $mailer = Omnimail::create('Silverpop', $parameters);
   *
   *   // Create the request object
   *   $myRequest = $mailer->myRequest($someParameters);
   * </code>
   *
   * @param string $class The request class name
   * @param array $parameters
   *
   * @return RequestInterface
   */
  protected function createRequest($class, array $parameters)
  {
    $class = "Omnimail\\Silverpop\\Requests\\" . $class;
    return new $class($parameters);
  }

}
