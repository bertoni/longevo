<?php
/**
 * File that brings the Order class
 *
 * PHP Version 5.6
 *
 * @category Entity
 * @package  Attendance
 * @name     Order
 * @author   Arnaldo Bertoni <arnaldo.bertoni01@fatec.sp.gov.br>
 * @license  https://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://br.linkedin.com/in/abertoni
 */

namespace AttendanceBundle\Entity;

/**
 * Order class
 *
 * @category Entity
 * @package  Attendance
 * @author   Arnaldo Bertoni <arnaldo.bertoni01@fatec.sp.gov.br>
 * @license  https://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://br.linkedin.com/in/abertoni
 */
class Order
{
    /**
     * @var integer
     */
    protected $id;
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $tickets;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tickets = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Add ticket
     *
     * @param \AttendanceBundle\Entity\Ticket $ticket
     *
     * @return Order
     */
    public function addTicket(\AttendanceBundle\Entity\Ticket $ticket)
    {
        $this->tickets[] = $ticket;

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \AttendanceBundle\Entity\Ticket $ticket
     */
    public function removeTicket(\AttendanceBundle\Entity\Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }
}
