<?php

abstract class ua5Action extends sfAction
{
    /**
     * Appends the given data as JSON to the response content and bypasses the built-in view system.
     *
     * This method must be called as with a return:
     *
     * <code>return $this->renderJson($myData)</code>
     *
     * @param string $json JSON to append to the response
     *
     * @return sfView::NONE
     */
    public function renderJson($json, $jsonp = false)
    {
        self::setJsonResponseHeaders(
            $this->getResponse(),
            false === $jsonp ? null : 'application/javascript'
        );

        if (sfConfig::get('sf_debug')) {
            $debug = array();
            if (array_key_exists('debug', $json)) {
                $debug = $json['debug'];
            }

            $debug_info = new ua5JsonDebugInfo();

            $json['debug'] = array_merge(
                $debug_info->jsonSerialize(),
                $debug
            );
        }

        $output = json_encode($json);
        if (false !== $jsonp) {
            $output = sprintf('%s(%s)', $jsonp, $output);
        }
        return $this->renderText($output);
    }


    public function renderJsonSuccess($json = array(), $jsonp = false)
    {
        $default_data = array(
            'status' => 'success',
        );
        return $this->renderJson(array_merge($default_data, $json), $jsonp);
    }


    public function renderJsonError($errors = array(), $jsonp = false)
    {
        $data = array(
            'status' => 'error',
            'errors' => $errors
        );
        return $this->renderJson($data, $jsonp);
    }


    public function setResponseCacheDuration($timeout)
    {
        $response = $this->getResponse();

        if ( false === $timeout || 0 === $timeout ) {
            // prevent response caching on client side
            $response->addCacheControlHttpHeader('no-cache, must-revalidate');
            $response->setHttpHeader('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');
        } else {
            //-- References:
            //   https://developers.google.com/speed/docs/best-practices/caching
            //
            /* */
            //-- What it seems like we should send
            $response->addCacheControlHttpHeader(sprintf('max-age=%s, public, must-revalidate', $timeout));
            $response->setHttpHeader('Expires', gmdate('D, j M Y H:i:s \G\M\T', time()+$timeout));
            $response->setHttpHeader('Last-modified', gmdate('D, j M Y H:i:s \G\M\T', time()));
            @header_remove('Pragma');

            /*
            //-- Attempts to make it work
            $response->addCacheControlHttpHeader(sprintf('max-age=%s, public', $timeout));
            $response->setHttpHeader('Expires', gmdate('D, j M Y H:i:s \G\M\T', time()+$timeout));
            $response->setHttpHeader('Last-modified', 'Mon, 26 Jul 1997 05:00:00 GMT');
            //$response->setHttpHeader('Pragma', 'public');
            header_remove('Cookie');
            header_remove('Set-Cookie');
            */
        }
        return $response;
    }


    public static function setJsonResponseHeaders(sfResponse $response, $content_type = null)
    {
        if (null === $content_type) {
            $content_type = 'application/json';
        }
        $response->setContentType($content_type);

        return $response;
    }


    /**
     * Forwards current action to the default 403 error action unless the specified condition is true.
     *
     * @param bool    $condition  A condition that evaluates to true or false
     *
     */
    public function forward403Unless($condition)
    {
        if (!$condition) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }
    }

    /**
     * Generic form error output.
     */
    protected function renderFormJsonError(sfFormDoctrine $form)
    {
        $errors = array();
        foreach ($form->getFormFieldSchema() as $name => $field) {
            //-- Taken from `sfFormField::renderError`.
            $error = $field->getWidget() instanceof sfWidgetFormSchema
                ? $field->getWidget()->getGlobalErrors($field->getError())
                : $field->getError();
            if (null !== $error) {
                $errors[] = $error->getMessage();
            }
        }
        return $this->renderJsonError($errors);
    }
}
