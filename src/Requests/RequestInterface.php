<?php
/**
 * Created by IntelliJ IDEA.
 * User: emcnaughton
 * Date: 5/4/17
 * Time: 10:35 AM
 */

namespace Omnimail\Silverpop\Requests;


interface RequestInterface {

  public function getResponse();

  public function getDefaultParameters();
}
