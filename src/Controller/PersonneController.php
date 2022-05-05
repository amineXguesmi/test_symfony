<?php

namespace App\Controller;

use App\Entity\Personne;

use App\Form\PersonneType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    //select *
   #[Route('/personne',name: 'personne_acc')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repositery=$doctrine->getRepository(personne::class);
       $personne= $repositery->findAll();
        return $this->render('personne/index.html.twig',[
            'persone'=>$personne
        ]);
    }
    //select by id  ;; param converter
    #[Route('/personne/{id<\d+>}',name: 'personne_detail')]
    public function detail(Personne $user =null,$id ): Response{
//       $repository=$doctrine->getRepository(personne::class);
//        $user = $repository->find($id);
       if(!$user){
           $this->addFlash("error","il n'existe pas un user qui a ce id $id");
           return $this->redirectToRoute('personne_acc');
       }
       else{
           return $this->render('personne/index.html.twig',[
               'user'=>$user,
           ]);
       }
    }
    //pagination select by attribut
    #[Route('/personne/all/{page}/{nbre}',name: 'personne_all')]
    public function allPersonne(ManagerRegistry $doctrine,$nbre,$page): Response
    {
        $repositery=$doctrine->getRepository(personne::class);
//        $personne= $repositery->findBy(['age'=>40],['name'=>'ASC],3,1);
//        pagination :
        $personne= $repositery->findBy([],[],$nbre,($nbre-1)*$page);
        return $this->render('personne/index.html.twig',[
            'personne'=>$personne
        ]);
    }

//ajout sans formulaire
//    #[Route('/personne/add', name: 'app_personne')]
//    public function addPersonne(ManagerRegistry $doctrine): RedirectResponse
//    {
//        $entityManager=$doctrine->getManager();
//        $persone= new Personne();
//        $persone->setName("amine");
//        $persone->setAge("20");
//        $persone->setFirstname("gasmi");
//        $entityManager->persist($persone);
//      $entityManager->flush();
//
//        return $this->redirectToRoute('personne_acc');
//    }
//ajout avec formulaire
    #[Route('/personne/add', name: 'app_personne')]
    public function addPersonne(ManagerRegistry $doctrine,Request $request): Response
    {  $entityManager=$doctrine->getManager();
  $personne=new Personne();
$form=$this->createForm(PersonneType::class,$personne);
$form->handleRequest($request);
if(!$form->isSubmitted()){
return $this->render('personne/add_personne.html.twig',[
    'form'=>$form->createView(),
]);}
else{
    $entityManager->persist($personne);
    $entityManager->flush();
    $this->addFlash('success',$personne->getFirstname().' est ajouté avec success');
    return $this->redirectToRoute('personne_acc');
}
    }
    //Mise a jour
    #[Route('/personne/edit/{id?0}', name: 'edit_personne')]
    public function editPersonne(ManagerRegistry $doctrine,Personne $personne = null,Request $request): Response
    {  $entityManager=$doctrine->getManager();
        $new=false;
        if(!$personne){
            $personne=new Personne();
            $new=true;
        }
        $form=$this->createForm(PersonneType::class,$personne);
        $form->handleRequest($request);
        if(!$form->isSubmitted()){
            return $this->render('personne/add_personne.html.twig',[
                'form'=>$form->createView(),
            ]);}
        else{
            $entityManager->persist($personne);
            $entityManager->flush();
            if(!$new){
            $this->addFlash('success',$personne->getFirstname().' est edité avec success');}
            else{            $this->addFlash('success',$personne->getFirstname().' est ajouté avec success');}
        }
            return $this->redirectToRoute('personne_acc');
        }

//supp
    #[Route('/personne/supp/{id}', name: 'del_personne')]
    public function DeletePersonne(ManagerRegistry $doctrine,Personne $user=null): RedirectResponse
    {
       if($user){
           $Manager=$doctrine->getManager();
           $Manager->remove($user);
           $Manager->flush();
           $this->addFlash('success',"personne supprimer avec success");
       }
       else{
           $this->addFlash('error',"tu ne peux pas supp ce id car il n'existe pas");
       }
       return $this->redirectToRoute('personne_acc');

    }
    //update
    #[Route('/personne/update/{id}/{fname}/{name}/{age}', name: 'update_personne')]
    public function updatePersonne(ManagerRegistry $doctrine,Personne $user=null,$name,$fname,$age):RedirectResponse
    {
        if(!$user){
            $this->addFlash('error',"tu ne peux pas supp ce id car il n'existe pas");
        }
        else{
            $user->setName($name);
            $user->setAge($age);
            $user->setFirstname($fname);
            $Manager=$doctrine->getManager();
            $Manager->persist($user);
            $Manager->flush();
            $this->addFlash('success',"personne update avec success");

        }
           return $this->redirectToRoute('personne_acc');

    }

    //select by age entre min et max
    #[Route('/personne/inter/{min<\d+>}/{max<\d+>}',name: 'personne_inter')]
    public function testIntervall(ManagerRegistry $doctrine,Personne $user =null,$min,$max ): Response{
        $repository=$doctrine->getRepository(Personne::class);
        $personnes=$repository->findByPersonneParAgeInterval($min,$max);
        return $this->render('personne/index.html.twig',[
            'personne'=>$personnes
        ]);
   }
   //avg and count ...
    #[Route('/personne/stat/{min<\d+>}/{max<\d+>}',name: 'personne_stat')]
    public function testStat(ManagerRegistry $doctrine,Personne $user =null,$min,$max ): Response{
        $repository=$doctrine->getRepository(Personne::class);
        $stats=$repository->statByPersonneParAgeInterval($min,$max);
        return $this->render('personne/stat.html.twig',[
            'stat'=>$stats
        ]);
    }
}
