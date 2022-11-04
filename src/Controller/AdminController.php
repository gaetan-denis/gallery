<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Painting;
use App\Form\PaintingType;
use App\Repository\CommentRepository;
use App\Repository\PaintingRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(PaintingRepository $paintingRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $painting=$paintingRepository->findBy(
            [],
            ['id'=>'DESC']
        );
        $pagination=$paginator->paginate(
            $painting,
            $request->query->getInt('page',1),
            8
        );
        return $this->render('pages/admin/admin.html.twig', [
            'paintings' => $pagination,
        ]);
    }

    #[Route('admin/edit/{id}', name: 'edit')]
    public function edit( Painting $painting, EntityManagerInterface $manager, Request $request ): Response
    {
        $image = $painting->getImage();
        $form = $this->createForm(PaintingType::class, $painting);
        $form->handleRequest($request);
        $slug = new Slugify();
        if ($form->isSubmitted() && $form->isValid()) {
            $painting->setSlug($slug->slugify($form->get('titre')->getData()))
                     ->setImage($image);
            $manager->persist($painting);
            $manager->flush();
            $this->addFlash('success','L\'oeuvre a bien été modifié !');
            return $this->redirectToRoute('admin');
        }

        return $this->renderForm('pages/admin/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('admin/delete/{id}', name: 'delete')]
    public function delete( Painting $painting, EntityManagerInterface $manager ): Response
    {
        $manager->remove($painting);
        $manager->flush();
        $this->addFlash('success', 'Vous avez supprimé votre commentaire');
        return $this->redirectToRoute('admin');
    }

    #[Route('/admin/comment', name: 'comment')]
    public function comment( PaginatorInterface $paginator, Request $request, CommentRepository $commentRepository): Response
    {
        $comment=$commentRepository->findBy(
            [],
            ['id'=>'DESC']
        );
        $pagination=$paginator->paginate(
            $comment,
            $request->query->getInt('page',1),
            8
        );
        return $this->render('pages/admin/comment.html.twig', [
            'comments' => $pagination,
        ]);
    }

    #[Route('/admin/comment/view/{id}', name: 'view')]
    public function view( EntityManagerInterface $manager, Comment $comment): Response
    {
        $comment->setIsPublished(!$comment->isIsPublished());
        $manager->flush();
        $this->addFlash('success','l\'action a bien été entrepris');
        return $this->redirectToRoute('comment');
    }
}
