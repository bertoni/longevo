<?php
/**
 * File that brings the Ticket class
 *
 * PHP Version 5.6
 *
 * @category Entity
 * @package  Attendance
 * @name     Ticket
 * @author   Arnaldo Bertoni <arnaldo.bertoni01@fatec.sp.gov.br>
 * @license  https://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://br.linkedin.com/in/abertoni
 */

namespace AttendanceBundle\Entity;

/**
 * Ticket class
 *
 * @category Entity
 * @package  Attendance
 * @author   Arnaldo Bertoni <arnaldo.bertoni01@fatec.sp.gov.br>
 * @license  https://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://br.linkedin.com/in/abertoni
 */
class Ticket
{
    /**
     * @var integer
     */
    protected $id;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $observation;
    /**
     * @var integer
     */
    protected $order_id;
    /**
     * @var \AttendanceBundle\Entity\Order
     */
    protected $order;
    /**
     * @var integer
     */
    protected $customer_id;
    /**
     * @var \AttendanceBundle\Entity\Customer
     */
    protected $customer;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Ticket
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set observation
     *
     * @param string $observation
     *
     * @return Ticket
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get observation
     *
     * @return string
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * Set customerId
     *
     * @param integer $customerId
     *
     * @return Ticket
     */
    public function setCustomerId($customerId)
    {
        $this->customer_id = $customerId;

        return $this;
    }

    /**
     * Get customerId
     *
     * @return integer
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * Set orderId
     *
     * @param integer $orderId
     *
     * @return Ticket
     */
    public function setOrderId($orderId)
    {
        $this->order_id = $orderId;

        return $this;
    }

    /**
     * Get orderId
     *
     * @return integer
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Set customer
     *
     * @param \AttendanceBundle\Entity\Customer $customer
     *
     * @return Ticket
     */
    public function setCustomer(\AttendanceBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AttendanceBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set order
     *
     * @param \AttendanceBundle\Entity\Order $order
     *
     * @return Ticket
     */
    public function setOrder(\AttendanceBundle\Entity\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \AttendanceBundle\Entity\Order
     */
    public function getOrder()
    {
        return $this->order;
    }
}
