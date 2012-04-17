<?php

/**
 * Sends one email for every log call via the configured mailer. If this isn't configured
 * under sfAggregateLogger and an exception is throw in the application, sends
 * an email with the exception stack trace as the message body (see exception_format).
 *
 * @author Aaron Hall <adhall@gmail.com>
 *
 */
class ua5EmailLogger extends sfLogger {

  protected
    $subject_format   = 'Application error',
    $body_format      = 'Time: %time%%EOL%Priority: %priority%%EOL%%EOL%%message%%EOL%%EOL%%request%',
    $time_format      = '%b %d %H:%M:%S',
    $exception_format = '[%class%] %message%%EOL%%EOL%%trace%',
    $request_format   = '%method% %uri% (%xhr%)%EOL%%EOL%[IP] %ip%%EOL%[USER_AGENT] %user_agent%%EOL%[GET] %get%%EOL%[POST] %post%%EOL%Referrer: %referrer%%EOL%Forwarded-for: %forwarded_for%',
    $recipients       = null, // string address or array of addresses
    $from             = null;


  public function initialize(sfEventDispatcher $dispatcher, $options = array()) {
    $this->extractOptions(array(
      'subject_format',
      'body_format',
      'time_format',
      'exception_format',
      'recipients',
      'from',
    ), $options);

    return parent::initialize($dispatcher, $options);
  }


  protected function extractOptions($keys, $options) {
    foreach ( $keys as $key ) {
      if ( isset($options[$key]) ) {
        $this->$key = $options[$key];
      }
    }
  }


  public function listenToLogEvent(sfEvent $event) {
    $priority = isset($event['priority']) ? $event['priority'] : self::INFO;

    if ( $event->getSubject() instanceof Exception ) {
      if ( $this->getLogLevel() >= $priority ) {
        $this->doLogException($event->getSubject(), $priority);
      }
    } else {
      parent::listenToLogEvent($event);
    }
  }


  protected function doLogException(Exception $e, $priority) {
    $message = strtr($this->exception_format, array(
      '%class%'   => get_class($e),
      '%message%' => $e->getMessage(),
      '%trace%'   => $e->getTraceAsString(),
      '%EOL%'     => PHP_EOL,
    ));

    $this->doLog($message, $priority);
  }


  protected function doLog($message, $priority) {
    $request = sfContext::getInstance()->getRequest();
    $request_map = array(
      '%method%'        => $request->getMethod(),
      '%uri%'           => $request->getUri(),
      '%xhr%'           => $request->isXmlHttpRequest() ? 'XHR' : 'non-XHR',
      '%ip%'            => $_SERVER['REMOTE_ADDR'],
      '%user_agent%'    => $_SERVER['HTTP_USER_AGENT'],
      '%get%'           => $request->getGetParameters() ? self::buildParameterString($request->getGetParameters()) : '(empty)',
      '%post%'          => $request->getPostParameters() ? self::buildParameterString($request->getPostParameters()) : '(empty)',
      '%referrer%'      => $request->getReferer() ? $request->getReferer() : '(empty)',
      '%forwarded_for%' => is_array($request->getForwardedFor()) ? implode(', ', $request->getForwardedFor()) : '(empty)',
      '%EOL%'           => PHP_EOL,
    );

    $body_map = array(
      '%time%'     => strftime($this->time_format),
      '%priority%' => self::getPriorityName($priority),
      '%message%'  => $message,
      '%request%'  => strtr($this->request_format, $request_map),
      '%EOL%'      => PHP_EOL,
    );

    $subject = strtr($this->subject_format, $body_map);
    $body = strtr($this->body_format, $body_map);

    $this->doMail($subject, $body);
  }


  /**
   * Send the email. Exception thrown by Swift are not handled.
   *
   * @param string $subject The message subject
   * @param string $body The message body
   */
  protected function doMail($subject, $body) {
    try {
      sfContext::getInstance()->getMailer()->composeAndSend($this->from, $this->recipients, $subject, $body);
    } catch(Exception $e) {
      // do nothing
    }
  }


  static protected function buildParameterString(array $params) {
    $parts = array();

    foreach ( $params as $key => $val ) {
      if ( is_array($val) ) {
        $parts[] = "{$key}: {" . self::buildParameterString($val) . "}";
      } else {
        $parts[] = $val ? "{$key}: $val" : $key;
      }
    }

    return implode(', ', $parts);
  }


}
