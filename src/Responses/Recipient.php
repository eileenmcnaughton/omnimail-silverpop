<?php
/**
 * Created by IntelliJ IDEA.
 * User: emcnaughton
 * Date: 5/4/17
 * Time: 7:34 AM
 */
namespace Omnimail\Silverpop\Responses;

use SilverpopConnector\SilverpopConnector;
use SilverpopConnector\SilverpopConnectorException;
use Omnimail\Exception\InvalidRequestException;

class Recipient
{

  /**
   * @var array
   */
  protected $data = array();

  /**
   * @var string
   */
  protected $email;

  /**
   * Provider identifier for the sent mailing.
   *
   * @var string
   */
  protected $mailingIdentifier;

  /**
   *  Provider identifier for the contact.
   *
   * @var string
   */
  protected $contactIdentifier;

  /**
   * @var int Recipient Action.
   *   One of the event constants.
   */
  protected $recipientAction;

  /**
   * @var string timestamp
   */
  protected $recipientActionTimestamp;

  /**
   * @var string
   */
  protected $contactReference;

  const EVENT_SEND = 1, EVENT_OPEN = 2;

  /**
   * @return string
   */
  public function getEmail() {
    return (string) $this->email ? : $this->data['email'];
  }

  /**
   * @param string $email
   */
  public function setEmail($email) {
    $this->email = $email;
  }

  /**
   * @return mixed
   */
  public function getRecipientAction() {
    return $this->data['event_type'];
  }

  /**
   * @param mixed $recipientAction
   */
  public function setRecipientAction($recipientAction) {
    $this->recipientAction = $recipientAction;
  }

  /**
   * @return mixed
   */
  public function getRecipientActionTimestamp() {
    return $this->data['recipient_action_timestamp'];
  }

  /**
   * @param mixed $recipientActionTimestamp
   */
  public function setRecipientActionTimestamp($recipientActionTimestamp) {
    $this->recipientActionTimestamp = $recipientActionTimestamp;
  }

  /**
   * @return mixed
   */
  public function getContactReference() {
    return (string) $this->contactReference ? : $this->data['contact_identifier'];
  }

  /**
   * @param mixed $contactReference
   */
  public function setContactReference($contactReference) {
    $this->contactReference = $contactReference;
  }

  /**
   * @return mixed
   */
  public function getContactIdentifier() {
    return $this->contactIdentifier ? : $this->data['contact_identifier'] ;
  }

  /**
   * @param mixed $contactIdentifier
   */
  public function setContactIdentifier($contactIdentifier) {
    $this->contactIdentifier = $contactIdentifier;
  }

  /**
   * @var  SilverpopConnector
   */
  protected $silverPop;

  public function __construct($data) {
    $this->data = $data;
  }

  public function getName() {
    return (string) $this->data->MailingName;
  }

  public function getMailingIdentifier() {
    return (string) $this->data['mailing_identifier'];
  }

  public function getSubject() {
    return (string) $this->data->Subject;
  }

  public function getScheduledDate() {
    return strtotime((string) $this->data->ScheduledTS);
  }

  public function getSendStartDate() {
    return strtotime((string) $this->data->SentTS);
  }

  public function getHtmlBody() {
    if (!$this->template) {
      $this->setTemplate();
    }
    return (string) $this->template->HTMLBody;
  }

  public function getTextBody() {
    if (!$this->template) {
      $this->setTemplate();
    }
    return (string) $this->template->TextBody;
  }

  protected function setTemplate() {
    $silverPop = $this->getSilverPop();
    $this->template = $silverPop->getMailingTemplate(array('MailingId' => (string) $this->data->ParentTemplateId));
  }

  public function getNumberSent() {
    return $this->getStatistic('NumSent');
  }

  /**
   * Get the number of times emails from this mailing have been opened.
   *
   * An individual opening the email 5 times would count as 5 opens.
   *
   * @return int
   */
  public function getNumberOpens() {
    return $this->getStatistic('NumGrossOpen');
  }

  /**
   * Get the number of unique times emails from this mailing have been opened.
   *
   * An individual opening the email 5 times would count as 1 open.
   *
   * @return int
   */
  public function getNumberUniqueOpens() {
    return $this->getStatistic('NumUniqueOpen');
  }

  /**
   * Get the number of unsubscribes received from the mailing.
   *
   * @return int
   */
  public function getNumberUnsubscribes() {
    return $this->getStatistic('NumUnsubscribes');
  }

  /**
   * Get the number of abuse reports made about the mailing.
   *
   * Most commonly abuse reports include marking an email as spam.
   *
   * @return int
   */
  public function getNumberAbuseReports() {
    return $this->getStatistic('NumGrossAbuse');
  }

  /**
   * Get the number of bounces from the email.
   *
   * @return int
   */
  public function getNumberBounces() {
    return $this->getStatistic('NumBounceSoft');
  }

  /**
   * Get the number of emails suppressed by the provider.
   *
   * Mailing providers may contain their own lists of contacts to not sent mail to.
   * This number reflects the number of emails not sent due to the provider
   * suppressing them.
   *
   * @return int
   */
  public function getNumberSuppressedByProvider() {
    return $this->getStatistic('NumSuppressed');
  }

  /**
   * Get the number of emails blocked by the recipient's provider.
   *
   * Providers such as AOL, gmail may block some or all of the emails
   * based on whitelisting and blacklisting. This returns that number.
   *
   * @return int
   */
  public function getNumberBlocked() {
    return $this->getStatistic('NumGrossMailBlock');
  }

  /**
   * Get Silverpop connector object.
   *
   * @return \SilverpopConnector\SilverpopXmlConnector
   */
  protected function getSilverPop() {
    if (!$this->silverPop) {
      $this->silverPop = SilverpopConnector::getInstance();
    }
    return $this->silverPop;
  }

}
