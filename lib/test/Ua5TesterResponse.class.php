<?php

class Ua5TesterResponse extends sfTesterResponse
{
    public function isContentType($content_type)
    {
        $want = strtolower($content_type);
        $have = strtolower($this->response->getContentType());
        if ( $want == $have ) {
            $this->tester->pass(sprintf('Content Type "%s" matches "%s"', $have, $want));
        } else {
            $this->tester->fail(sprintf('Content Type "%s" does not match "%s"', $have, $want));
        }
        return $this->getObjectToReturn();
    }
}
