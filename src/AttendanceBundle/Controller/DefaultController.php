<?php

namespace AttendanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AttendanceBundle\Entity\Customer;
use AttendanceBundle\Entity\Order;
use AttendanceBundle\Entity\Ticket;

class DefaultController extends Controller
{
    /**
     * Add page Attendance Ticket
     *
     * @param Request $Request
     *
     * @access public
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('AttendanceBundle:Default:index.html.twig');
    }

    /**
     * Creates new Attendance Ticket
     *
     * @param Request $Request
     *
     * @access public
     * @return JsonResponse
     */
    public function addTicketAction(Request $Request)
    {
        $name        = $Request->get('name',        '');
        $email       = $Request->get('email',       '');
        $order_id    = $Request->get('order_id',    '');
        $title       = $Request->get('title',       '');
        $observation = $Request->get('observation', '');
        
        if (!strlen($name)) {
            return new JsonResponse(array('message' => 'Nome obrigatório'), 400);
        }
        if (!strlen($email)) {
            return new JsonResponse(array('message' => 'Email obrigatório'), 400);
        }
        if (!strlen($order_id)) {
            return new JsonResponse(array('message' => 'Número do Pedido obrigatório'), 400);
        }
        if (!strlen($title)) {
            return new JsonResponse(array('message' => 'Título obrigatório'), 400);
        }
        if (!strlen($observation)) {
            return new JsonResponse(array('message' => 'Observação obrigatória'), 400);
        }
        
        $Order = $this->getDoctrine()
            ->getRepository('AttendanceBundle:Order')
            ->find($order_id);
        if (!$Order) {
            return new JsonResponse(array('message' => 'Pedido não encontrado'), 400);
        }
        
        $Customer = $this->getDoctrine()
            ->getRepository('AttendanceBundle:Customer')
            ->findBy(array('email' => $email));
        if (!count($Customer)) {
            $Customer = new Customer();
            $Customer->setName($name)
                ->setEmail($email);
            
            try {
                $this->getDoctrine()->getManager()->persist($Customer);
                $this->getDoctrine()->getManager()->flush();
            } catch (\Exception $e) {
                return new JsonResponse(array('message' => 'Não foi possível criar o chamado'), 400);
            }
        } else {
            $Customer = $Customer[0];
        }
        
        $Ticket = new Ticket();
        $Ticket->setTitle($title)
            ->setObservation($observation)
            ->setCustomer($Customer)
            ->setOrder($Order);
        
        try {
            $this->getDoctrine()->getManager()->persist($Ticket);
            $this->getDoctrine()->getManager()->flush();
        } catch (\Exception $e) {
            return new JsonResponse(array('message' => 'Não foi possível criar o chamado'), 400);
        }
        
        return new JsonResponse(array('message' => 'Chamado criado com sucesso!'), 200);
    }

    /**
     * List page Attendance Ticket
     *
     * @param Request $Request
     *
     * @access public
     * @return Response
     */
    public function listAction(Request $Request)
    {
        $arr_tickets = array();
        
        $pagina     = $Request->get('pagina', 1);
        $quantidade = 5;
        $offset     = ($pagina < 2 ? 0 : ($pagina-1) * $quantidade);
        
        $filters  = array();
        $order_id = $Request->get('order_id', '');
        $email    = $Request->get('email',    '');
        
        $order = null;
        if (strlen($order_id)) {
            $order = $order_id;
        }
        
        $customer_email = null;
        if (strlen($email)) {
            $customer_email = $email;
        }
        
        $Tickets = $this->getDoctrine()
            ->getRepository('AttendanceBundle:Ticket')
            ->getByFilters($offset, $quantidade, 'id', 'DESC', $order, $customer_email);
        if (count($Tickets)) {
            foreach ($Tickets as $Ticket) {
                $arr_tickets[] = array(
                    'id' => $Ticket->getId(),
                    'customer' => array(
                        'name'  => $Ticket->getCustomer()->getName(),
                        'email' => $Ticket->getCustomer()->getEmail()
                    ),
                    'order' => array(
                        'id' => $Ticket->getOrder()->getId()
                    ),
                    'title'       => $Ticket->getTitle(),
                    'observation' => $Ticket->getObservation()
                );
            }
        }
        
        return $this->render(
            'AttendanceBundle:Default:list.html.twig',
            array(
                'tickets'  => $arr_tickets,
                'page'     => $pagina,
                'email'    => $customer_email,
                'order_id' => $order
            )
        );
    }
}