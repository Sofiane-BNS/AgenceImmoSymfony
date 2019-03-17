<?php
namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PropertyController extends AbstractController 
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em; // Facon de récuperer l'entite manager
    public function __construct(PropertyRepository $repository,ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em=$em;
    }

    /**
	* @Route("/biens",name="property.index")
	* @return Response
	*/
	public function index():Response
	{
	    /* INSERTION
	    $property=new Property();
	    $property->setTitle('Mon premier bien')
            ->setPrice(200000)
            ->setRooms(4)
            ->setBedrooms(3)
            ->setDescription('une petite description')
            ->setSurface(60)
            ->setFloor(4)
            ->setHeat(1)
            ->setCity('Montpellier')
            ->setAddress('15 Boulevard Gambetta')
            ->setPostalCode('34000');

	    $em = $this->getDoctrine()->getManager();
	    $em->persist($property);
	    $em->flush();//permet d'envoyer tout ce qu'il ya dans l'entité manager dans la BD
	    */

	    /*RECUPERATION de données (il faut utiliser le repository ici)
        $repository=$this->getDoctrine()->getRepository(Property::class); //1ere maniere de faire les choses
        $property = $this->repository->find(1);
        $properties = $this->repository->findAll();
        $property2 =  $this->repository->findOneBy(['floor' => 4]);
        $propertiesVisble = $this->repository->findAllVisible();
        dump($propertiesVisble);  */

	    /*Modification d'une donnée
        $propertiesVisble = $this->repository->findAllVisible();
        $propertiesVisble[0]->setSold(true);
        $this->em->flush();//automatiquement le flush detecte que l'entité a été modifié et update la BD*/


		return $this->render('property/index.html.twig',[
			'current_menu' => 'properties'
		]);
	}

    /**
     * @Route("/biens/{slug}-{id}",name="property.show",requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @param string $slug
     * @return Response
     */
	// public function show($slug, $id):Response    (1ere facon de faire)
    public function show(Property $property, string $slug):Response //(2eme facon de faire, il voit un {id} dans la route il fait le find automatiquement)
    {
        // $property = $this->repository->find($id);  (1ere facon de faire)

        //Verification que le slug correspond bien
        if($property->getSlug()!== $slug) {
            return $this->redirectToRoute('property.show',[
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ],301);
        }

        return $this->render('property/show.html.twig',[
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }
}