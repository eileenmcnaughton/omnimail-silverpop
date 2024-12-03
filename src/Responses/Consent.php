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

class Consent {

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @return int|null
     */
    public function getStatus(): string {
        return $this->data['status'];
    }

    /**
     * @return array
     */
    public function getTimestamp(): int {
        return strtotime($this->data['consentDate']);
    }

    /**
     * @return string
     */
    public function getSource(): ?string {
        return $this->data['consentSource'];
    }

    /**
     * @var  SilverpopConnector
     */
    protected $silverPop;

    public function __construct($data) {
        $this->data = $data;
    }

}