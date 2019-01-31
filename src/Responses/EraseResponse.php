<?php
/**
 * Created by IntelliJ IDEA.
 * User: emcnaughton
 * Date: 5/4/17
 * Time: 7:34 AM
 */
namespace Omnimail\Silverpop\Responses;

class EraseResponse extends BaseResponse
{
    /**
     * Parameters for retrieving the results.
     *
     * @var array
     */
    protected $retrievalParameters;

    /**
     * @return array
     */
    public function getRetrievalParameters() {
        return ['job_id' => $this['data']['job_id'], 'database_id' => $this['data']['database_id']];
    }

    /**
     * Is the erasure completed.
     *
     * @return bool
     */
    public function isCompleted() {
        if (isset($this['data']['status'])) {
           return ($this['data']['status'] === 'COMPLETE');
        }
        return TRUE;
    }

}
