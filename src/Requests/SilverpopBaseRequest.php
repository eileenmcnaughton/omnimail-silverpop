<?php
/**
 * Created by IntelliJ IDEA.
 * User: emcnaughton
 * Date: 5/4/17
 * Time: 7:34 AM
 */
namespace Omnimail\Silverpop\Requests;
abstract class SilverpopBaseRequest extends BaseRequest {
  /**
   * @var \SilverpopConnector\SilverpopXmlConnector
   */
  protected $silverPop;

  /**
   * Timestamp for start of period.
   *
   * @var int
   */
  protected $startTimeStamp;

  /**
   * Timestamp for end of period.
   *
   * @var int
   */
  protected $endTimeStamp;

  protected int $retryDelay = 1;

  /**
   * Url to direct requests to.
   *
   * @var string
   */
  protected $endPoint;

  /**
   * User name
   *
   * @var string
   */
  protected $username;

  /**
   * Password
   *
   * @var string
   */
  protected $password;

  /**
   * Developer mode.
   *
   * In developer mode the authenticate request will not be sent and a mock client
   * will be used. This may, optionally, be passed in.
   *
   * @var bool
   */
  protected $developerMode;

  /**
   * Offset from start of csv file.
   *
   * @var int
   */
  protected $offset = 0;

    /**
     * Rows to retrieve.
     *
     * @var int
     */
  protected $limit = 0;

    /**
     * @return int
     */
    public function getLimit(): int {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit) {
        $this->limit = $limit;
    }


  public function getRetryDelay(): int {
    return $this->retryDelay;
  }

  public function setRetryDelay(int $retryDelay): void {
    $this->retryDelay = $retryDelay;
  }

  /**
   * @return int
   */
  public function getOffset() {
    return $this->offset;
  }

  /**
   * @param int $offset
   */
  public function setOffset($offset) {
    $this->offset = $offset;
  }

  /**
   * @return bool
   */
  public function isDeveloperMode() {
    return $this->developerMode;
  }

  /**
   * @param bool $developerMode
   */
  public function setDeveloperMode($developerMode) {
    $this->developerMode = $developerMode;
  }

  /**
   * @return string
   */
  public function getEndPoint() {
    return $this->endPoint;
  }

  /**
   * @param string $endPoint
   */
  public function setEndPoint($endPoint) {
    $this->endPoint = $endPoint;
  }

  /**
   * @return int
   */
  public function getStartTimeStamp() {
    return $this->startTimeStamp;
  }

  /**
   * @param int $startTimeStamp
   */
  public function setStartTimeStamp($startTimeStamp) {
    $this->startTimeStamp = $startTimeStamp;
  }

  /**
   * @return int
   */
  public function getEndTimeStamp() {
    return $this->endTimeStamp;
  }

  /**
   * @param int $endTimeStamp
   */
  public function setEndTimeStamp($endTimeStamp) {
    $this->endTimeStamp = $endTimeStamp;
  }

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
   * Get defaults for the api.
   *
   * @return array
   */
  public function getDefaultParameters() {
    return [
      'endpoint' => 'https://api-campaign-us-4.goacoustic.com',
      'sftpEndpoint' => 'transfer-campaign-us-4.goacoustic.com',
    ];
  }

}
