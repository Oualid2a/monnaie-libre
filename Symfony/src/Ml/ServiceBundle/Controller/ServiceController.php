<?php

namespace Ml\ServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Ml\ServiceBundle\Entity\Service;
use Ml\ServiceBundle\Entity\Carpooling;
use Ml\ServiceBundle\Entity\CarpoolingUser;
use Ml\ServiceBundle\Form\CarpoolingType;
use Ml\ServiceBundle\Entity\CouchSurfing;
use Ml\ServiceBundle\Entity\CouchSurfingUser;
use Ml\ServiceBundle\Form\CouchSurfingType;
use Ml\ServiceBundle\Entity\Sale;
use Ml\ServiceBundle\Entity\SaleUser;
use Ml\ServiceBundle\Form\SaleType;
use Ml\UserBundle\Entity\User;

class ServiceController extends Controller
{

	public function indexAction()
	{
		/* Test connexion */
		$req = $this->get('request');		
		$user=$this->sessionExist($req);

		if ($req->getMethod() == 'POST') {
			$carpooling = false;
			$couchsurfing=false;
			if ($req->request->get('type') != null) {
				foreach ($req->request->get('type') as $key => $value) {
					if ($value == 'carpooling') {
						$carpooling = true;
					}
					else if($value =='couchsurfing'){
						$couchsurfing = true;
					}

				}
				
				if ($carpooling == true) {
					$carpoolings = $this->getDoctrine()->getManager()->getRepository('MlServiceBundle:Carpooling')->findByVisibility(true);
					$services[] = $carpoolings;
				}
				elseif ($couchsurfing == true) {
					$couchsurfings = $this->getDoctrine()->getManager()->getRepository('MlServiceBundle:CouchSurfing')->findByVisibility(true);
					$services[] = $couchsurfings;
				}

			}
			else {
				/* Récupération de tous les Services du site */

				$carpoolings = $this->getDoctrine()->getManager()->getRepository('MlServiceBundle:Carpooling')->findByVisibility(true);
				$couchsurfings = $this->getDoctrine()->getManager()->getRepository('MlServiceBundle:CouchSurfing')->findByVisibility(true);								
				$services[] = $couchsurfings;
				$services[] = $carpoolings;
			}
		}
		else {
			/* Récupération de tous les Services du site */
			$carpoolings = $this->getDoctrine()->getManager()->getRepository('MlServiceBundle:Carpooling')->findByVisibility(true);
			$couchsurfings = $this->getDoctrine()->getManager()->getRepository('MlServiceBundle:CouchSurfing')->findByVisibility(true);								
			$services[] = $couchsurfings;
			$services[] = $carpoolings;
		}
		
		return $this->render('MlServiceBundle:Service:index.html.twig', array(
		  'servicess'=>$services,
		  'user' => $user));
	}	

	public function seeCarpoolingAction($carpooling = null)
	{
		$em=$this->getDoctrine()->getManager();
		$data_carpooling=$em->getRepository('MlServiceBundle:Carpooling')->findOneById($carpooling);
		
		/* Si le Service demandé n'existe pas */
		if($data_carpooling == null){
			return $this->redirect($this->generateUrl('ml_service_homepage'));
		}
		
		if($data_carpooling->getVisibility() == false) {
			return $this->redirect($this->generateUrl('ml_service_homepage'));
		}
		
		/* Test connexion */
		$req = $this->get('request');		
		$user=$this->sessionExist($req);
		
		if($req->getMethod() != 'POST'){			
			/* Si elle existe, elle est envoyée à la vue */
			return $this->render('MlServiceBundle:Service:see_carpooling.html.twig', array('user' =>$user,'carpool'=>$data_carpooling));
		}
		else {				
			$current_user = $em->getRepository('MlUserBundle:User')->findOneByLogin($user);
			
			$carpoolingUser = new CarpoolingUser;
			
			$carpoolingUser->setApplicant($current_user);
			$carpoolingUser->setCarpooling($data_carpooling);
			
			$em->persist($carpoolingUser);
			$em->flush();
			
			$data_carpooling->setVisibility(false);
			
			$em->persist($data_carpooling);
			$em->flush();

			return $this->redirect($this->generateUrl('ml_service_homepage'));
		}
	}
	
	public function addCarpoolingAction(){
		/* Test connexion */
		$req = $this->get('request');		
		$user=$this->sessionExist($req);

	
		$carpooling = new Carpooling;
		
		$form = $this->createForm(new CarpoolingType(),$carpooling);


		if($req->getMethod() == 'POST'){
			//lien requête<->form
			$form->bind($req);

			if($form->isValid()){			
				$em=$this->getDoctrine()->getManager();
				
				$current_user=$em->getRepository('MlUserBundle:User')->findOneByLogin($user);
				$carpooling->setUser($current_user);
				
				$em->persist($carpooling);
				$em->flush();

				//$this->get('session')->getFlashBag->add('ajouter', 'Votre service est ajoutée');
				
				$carpooling_id = $carpooling->getId();

				return $this->redirect($this->generateUrl('ml_service_see_carpooling', array('user'=>$user,'carpooling' => $carpooling_id)));
			}
		}
		// si le form n'est pas valide, on le redemande
		return $this->render('MlServiceBundle:Service:add_carpooling.html.twig', array(
			'form' => $form->createView(),
		    'user' => $user));
	}

	public function deleteCarpoolingAction(/*Service $service*/)
	{
		/* Test connexion */
		$req = $this->get('request');		
		$user=$this->sessionExist($req);

	
		$em=$this->getDoctrine()->getManager();
		$service=$em->getRepository('MlServiceBundle:Carpooling')->findById('3');
		
		$em->remove($service[0]);
		$em->flush();

		//$this->get('session')->getFlashBag->add('supprimer','Votre service a été supprimé');
		return $this->redirect($this->generateUrl('ml_service_homepage'));
	}

	private function sessionExist($req){
		// On récupère la requête
		$session = $req->getSession();		
		$user = $session->get('user');

		/* Si on est pas logger -> redirection vers la page d'inscription */
		if ($user == NULL) {
			return $this->redirect($this->generateUrl('ml_user_add'));
		}
		
		return $user;
	}

	public function addCouchSurfingAction(){
		/* Test connexion */
		$req = $this->get('request');		
		$user=$this->sessionExist($req);

	
		$couchsurfing = new CouchSurfing;
		
		$form = $this->createForm(new CouchSurfingType(),$couchsurfing);


		if($req->getMethod() == 'POST'){
			//lien requête<->form
			$form->bind($req);

			if($form->isValid()){			
				$em=$this->getDoctrine()->getManager();
				
				$current_user=$em->getRepository('MlUserBundle:User')->findOneByLogin($user);
				$couchsurfing->setUser($current_user);
				
				$em->persist($couchsurfing);
				$em->flush();

				//$this->get('session')->getFlashBag->add('ajouter', 'Votre service est ajoutée');
				
				$couchsurfing_id = $couchsurfing->getId();

				return $this->redirect($this->generateUrl('ml_service_see_couchsurfing', array('user'=>$user,'couchsurfing' => $couchsurfing_id)));
			}
		}
		// si le form n'est pas valide, on le redemande
		return $this->render('MlServiceBundle:Service:add_couchsurfing.html.twig', array(
			'form' => $form->createView(),
		    'user' => $user));
	}

	public function seeCouchSurfingAction($couchsurfing = null)
	{
		$em=$this->getDoctrine()->getManager();
		$data_couchsurfing=$em->getRepository('MlServiceBundle:CouchSurfing')->findOneById($couchsurfing);
		
		/* Si le Service demandé n'existe pas */
		if($data_couchsurfing == null){
			return $this->redirect($this->generateUrl('ml_service_homepage'));
		}
		
		if($data_couchsurfing->getVisibility() == false) {
			return $this->redirect($this->generateUrl('ml_service_homepage'));
		}
		
		/* Test connexion */
		$req = $this->get('request');		
		$user=$this->sessionExist($req);
		
		if($req->getMethod() != 'POST'){			
			/* Si elle existe, elle est envoyée à la vue */
			return $this->render('MlServiceBundle:Service:see_couchsurfing.html.twig', array('user' =>$user,'couch'=>$data_couchsurfing));
		}
		else {				
			$current_user = $em->getRepository('MlUserBundle:User')->findOneByLogin($user);
			
			$couchsurfingUser = new CouchSurfingUser;
			
			$couchsurfingUser->setApplicant($current_user);
			$couchsurfingUser->setCouchSurfing($data_couchsurfing);
			
			$em->persist($couchsurfingUser);
			$em->flush();
			
			$data_couchsurfing->setVisibility(false);
			
			$em->persist($data_couchsurfing);
			$em->flush();

			return $this->redirect($this->generateUrl('ml_service_homepage'));
		}
	}

	public function addSaleAction(){
		/* Test connexion */
		$req = $this->get('request');		
		$user=$this->sessionExist($req);

	
		$sale = new Sale;
		
		$form = $this->createForm(new SaleType(),$sale);


		if($req->getMethod() == 'POST'){
			//lien requête<->form
			$form->bind($req);

			if($form->isValid()){			
				$em=$this->getDoctrine()->getManager();
				
				$current_user=$em->getRepository('MlUserBundle:User')->findOneByLogin($user);
				$sale->setUser($current_user);
				
				$em->persist($sale);
				$em->flush();

				//$this->get('session')->getFlashBag->add('ajouter', 'Votre service est ajoutée');
				
				$sale_id = $sale->getId();

				return $this->redirect($this->generateUrl('ml_service_see_sale', array('user'=>$user,'sale' => $sale_id)));
			}
		}
		// si le form n'est pas valide, on le redemande
		return $this->render('MlServiceBundle:Service:add_sale.html.twig', array(
			'form' => $form->createView(),
		    'user' => $user));
	}

	public function seeSaleAction($sale = null)
	{
		$em=$this->getDoctrine()->getManager();
		$data_sale=$em->getRepository('MlServiceBundle:Sale')->findOneById($sale);
		
		/* Si le Service demandé n'existe pas */
		if($data_sale == null){
			return $this->redirect($this->generateUrl('ml_service_homepage'));
		}
		
		if($data_sale->getVisibility() == false) {
			return $this->redirect($this->generateUrl('ml_service_homepage'));
		}
		
		/* Test connexion */
		$req = $this->get('request');		
		$user=$this->sessionExist($req);
		
		if($req->getMethod() != 'POST'){			
			/* Si elle existe, elle est envoyée à la vue */
			return $this->render('MlServiceBundle:Service:see_sale.html.twig', array('user' =>$user,'sal'=>$data_sale));
		}
		else {				
			$current_user = $em->getRepository('MlUserBundle:User')->findOneByLogin($user);
			
			$saleUser = new SaleUser;
			
			$saleUser->setApplicant($current_user);
			$saleUser->setSale($data_sale);
			
			$em->persist($saleUser);
			$em->flush();
			
			$data_sale->setVisibility(false);
			
			$em->persist($data_sale);
			$em->flush();

			return $this->redirect($this->generateUrl('ml_service_homepage'));
		}
	}

}

