<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route(path: "wishes/", name: 'wishes_')]
class WishController extends AbstractController
{

    /**
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route(path: "", name: 'wishes', methods: ["GET"])]
    public function wishes(WishRepository $wishRepository): Response
    {
        // Récupère tous les souhaits
        //$wishes = $entityManager->getRepository(Wish::class)->getWishes();
        //on appelle la méthode personnalisée ici pour éviter d'avoir trop de requetes
        $wishes = $wishRepository->findPublishedWishesWithCategories();

        return $this->render("wish/list.html.twig", [
            //les passe a twig
            'wishes' => $wishes
        ]);
    }


    /**
     * @param EntityManagerInterface $entityManager
     * @param int $id
     * @return Response
     */
    #[Route(path: "{id}", name: 'detail', requirements: ['id' => '[0-9]\d*'], methods: ["GET"])]
    public function detail(EntityManagerInterface $entityManager, int $id): Response
    {

        $wish = $entityManager->getRepository(Wish::class)->getWishById($id);

        // Si aucun souhait n'est trouvé (soit il n'existe pas, soit il n'est pas publié), lance une exception
        if (!$wish) {
            throw $this->createNotFoundException('Le souhait n\'existe pas ou n\'est pas publié.');
        }

        return $this->render("wish/detail.html.twig", ['wish' => $wish]);
    }

    #[Route(path: "create", name: 'create', methods: ["GET", "POST"])]
    #[IsGranted('ROLE_CONTRIBUTOR')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response {

        $wish = new Wish();
        $form = $this->createForm(WishType::class, $wish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $wish->setDateCreated(new DateTime());
            $wish->setIsPublished(true);

            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash('success', 'Le souhait a bien été enregistré.');

            return $this->redirectToRoute('wishes_detail', ['id' => $wish->getId()]);
        }

        return $this->render('wish/create.html.twig', ['wish_form' => $form->createView()]);

    }

    #[Route(path: "update/{id}", name: 'update', requirements: ['id' => '[0-9]\d*'], methods: ["GET", "POST"])]
    #[IsGranted('ROLE_ADMIN')]
    public function update(Request $request, EntityManagerInterface $entityManager, Wish $wish, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(WishType::class, $wish);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash('success', 'Le souhait a bien été mis à jour.');

            return $this->redirectToRoute('wishes_detail', ['id' => $wish->getId()]);
        }

        return $this->render('wish/create.html.twig', ['wish_form' => $form->createView()]);
    }

}