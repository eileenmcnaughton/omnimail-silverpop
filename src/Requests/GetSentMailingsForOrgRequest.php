<?php
/**
 * Created by IntelliJ IDEA.
 * User: emcnaughton
 * Date: 5/4/17
 * Time: 7:34 AM
 */
namespace Omnimail\Silverpop\Requests;

use Omnimail\Silverpop\Responses\MailingsResponse;

class GetSentMailingsForOrgRequest extends BaseRequest
{

  /**
   * @var array
   */
  protected $statuses;

  /**
   * @var bool
   */
  protected $includeZeroSent;

  /**
   * @var bool
   */
  protected $includeTest;

  /**
   * @return array
   */
  public function getStatuses() {
    return $this->statuses;
  }

  /**
   * @param array $statuses
   */
  public function setStatuses($statuses) {
    $this->statuses = $statuses;
  }

  /**
   * @return bool
   */
  public function isIncludeZeroSent() {
    return $this->includeZeroSent;
  }

  /**
   * @param bool $includeZeroSent
   */
  public function setIncludeZeroSent($includeZeroSent) {
    $this->includeZeroSent = $includeZeroSent;
  }

  /**
   * @return bool
   */
  public function isIncludeTest() {
    return $this->includeTest;
  }

  /**
   * @param bool $includeTest
   */
  public function setIncludeTest($includeTest) {
    $this->includeTest = $includeTest;
  }

  /**
   * Get Reponse
   *
   * @return array
   */
  public function getResponse() {
    $flags = array('SHARED');
    if (!$this->isIncludeTest()) {
      $flags[] = 'EXCLUDE_TEST_MAILINGS';
    }
    if (!$this->isIncludeZeroSent()) {
      $flags[] = 'EXCLUDE_ZERO_SENT';
    }
    foreach ($this->getStatuses() as $status) {
      $flags[] = $status;
    }

    $mailings = $this->silverPop->getSentMailingsForOrg(
      $this->getStartTimeStamp(),
      $this->getEndTimeStamp(),
      $flags
    );
    $response = new MailingsResponse($mailings);
    $response->setSilverpop($this->silverPop);
    return $response;
  }

  /**
   * Get defaults for the api.
   *
   * @return array
   */
  public function getDefaultParameters() {
    return array(
      'endpoint' => 'https://api4.silverpop.com',
      'statuses' => array('sent', 'sending'),
      'includeZeroSent' => FALSE,
      'includeTest' => FALSE,
      'startTimeStamp' => strtotime('1 week ago'),
      'endTimeStamp' => strtotime('now'),
    );
  }

}
