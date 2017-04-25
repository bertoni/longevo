<?php
/**
 * File that brings the Load Data class
 *
 * PHP Version 5.6
 *
 * @category Entity
 * @package  Attendance
 * @name     LoadData
 * @author   Arnaldo Bertoni <arnaldo.bertoni01@fatec.sp.gov.br>
 * @license  https://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://br.linkedin.com/in/abertoni
 */

namespace AttendanceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;
use AttendanceBundle\Entity\Customer;
use AttendanceBundle\Entity\Order;
use AttendanceBundle\Entity\Ticket;

/**
 * Load Data class
 *
 * @category Entity
 * @package  Attendance
 * @author   Arnaldo Bertoni <arnaldo.bertoni01@fatec.sp.gov.br>
 * @license  https://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://br.linkedin.com/in/abertoni
 */
class LoadData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $seed = Yaml::parse(file_get_contents(__DIR__ . '/../../Resources/config/seeds/data.yml'));
        
        if (isset($seed['data']) && is_array($seed['data']) && count($seed['data'])) {
            foreach ($seed['data'] as $data) {
                $Customer = new Customer();
                $Customer->setName($data['customer']['name'])
                    ->setEmail($data['customer']['email']);
                $manager->persist($Customer);
                
                $Order = new Order();
                $manager->persist($Order);
                
                $manager->flush();
                
                $Ticket = new Ticket();
                $Ticket->setTitle($data['ticket']['title'])
                    ->setObservation($data['ticket']['observation'])
                    ->setCustomer($Customer)
                    ->setOrder($Order);
                
                $manager->persist($Ticket);
                $manager->flush();
            }
        }
    }
}