<?php
/**
 * File that brings the Ticket Repository class
 *
 * PHP Version 5.6
 *
 * @category Entity
 * @package  Attendance
 * @name     TicketRepository
 * @author   Arnaldo Bertoni <arnaldo.bertoni01@fatec.sp.gov.br>
 * @license  https://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://br.linkedin.com/in/abertoni
 */

namespace AttendanceBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Ticket Repository class
 *
 * @category Entity
 * @package  Attendance
 * @author   Arnaldo Bertoni <arnaldo.bertoni01@fatec.sp.gov.br>
 * @license  https://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://br.linkedin.com/in/abertoni
 */
class TicketRepository extends EntityRepository
{
    /**
     * Get Tickets by filters
     *
     * @access public
     * @return array[Ticket]
     */
    public function getByFilters($offset, $limit, $order, $sort, $order_id, $email)
    {
        $value = array();
        $sql   = 'SELECT t FROM AttendanceBundle:Ticket t JOIN AttendanceBundle:Customer c WITH c.id = t.customer_id WHERE 1 = 1';
        if (!is_null($order_id)) {
            $sql              .= ' AND t.order_id = :order_id';
            $value['order_id'] = $order_id;
        }
        if (!is_null($email)) {
            $sql           .= ' AND c.email = :email';
            $value['email'] = $email;
        }
        
        $query = $this->getEntityManager()->createQuery($sql);
        if (count($value)) {
            $query->setParameters($value);
        }
        if (!is_null($limit)) {
            $query->setMaxResults($limit);
        }
        if (!is_null($offset)) {
            $query->setFirstResult($offset);
        }
        return $query->getResult();
    }
}