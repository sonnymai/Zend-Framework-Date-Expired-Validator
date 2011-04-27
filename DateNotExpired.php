<?php
/**
 * This validates to compare a date to another date to make sure it has not passed already
 * @author     Son Hai Mai
 * @email      sonny@portfold.com
 * @website    http://blog.lowfiredanger.com.au
 * @copyright  Use it for watever you want!
 * @license    Use it for watever you want!
*/

require_once 'Zend/Validate/Abstract.php';

class My_Validate_DateNotExpired extends Zend_Validate_Abstract
{
  const DATE_NOT_EXPIRED = 'dateNotExpired';

  protected $_messageTemplates = array(
    self::DATE_NOT_EXPIRED  =>
      'Date has not expired'
  );

  protected $_messageVariables = array(
    'expirationDate' => '_expirationDate',
    'testDate' => '_testDate'
  );

  /**
   * Expiration date
   *
   * @var string dd-MM-YYYY
   */
  protected $_expirationDate;

  /**
   * Date to be tested against the expiration date
   *
   * @var Zend_Date
  */
  protected $_testDate;

  /**
   * Number of days to tolerate before raising invalidation. This is used in the
   * case where you want to adjust the comparison date by a few days.
   *
   * @var int
  */
  protected $_tolerance;
  /**
   * Sets validator options
   *
   * @param  Zend_Date $expirationDate
   * @param int $tolerance
   * @return void
  */
  public function __construct($expirationDate, $tolerance = 0) {
    $this->setExpirationDate($expirationDate);
    $this->setTolerance($tolerance);
  }

  /**
   * Returns the expiration date.
   *
   * @return string
  */
  public function getExpirationDate() {
    return $this->_expirationDate;
  }

  /**
   * Sets the Expiration date.
   *
   * @param  Zend_Date $expirationDate
   * @return Zend_Date $expirationDate
  */
  public function setExpirationDate($expirationDate) {
    $this->_expirationDate = $expirationDate;
    return $this;
  }


  /**
   * Returns the tolerence days.
   *
   * @return int
  */
  public function getTolerance() {
    return $this->_tolerance;
  }

  /**
   * Sets the Expiration date.
   *
   * @param  int $_tolerence
   * @return My_Validate_DateNotExpired
  */
  public function setTolerance($tolerance) {
    $this->_tolerance = $tolerance;
    return $this;
  }

  /**
   * Defined by Zend_Validate_Interface
   *
   * Returns true if and only the date in $value has not surpassed ($this->expirationDate + $tolerance)
   *
   * @param  string $value dd-MM-YYYY
   *
   * @return boolean
  */
  public function isValid($value) {
    $this->_setValue($value);
    $expirationDate = $this->getExpirationDate();

    $testDate = new Zend_Date($value, 'dd-MM-YYYY');

    if($testDate->isEarlier($expirationDate->sub($this->getTolerance(), Zend_Date::DAY))){
        $this->_error(self::DATE_NOT_EXPIRED);
        //date has passed
        return false;
    }else{
        //date has not passed yet
        return true;
    }

  }
}