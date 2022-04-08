<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Persistence\ManagerRegistry;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;

use App\Entity\Category;

use App\Form\CategoryType;

/**
 * @Route("/category", name="category_")
 */

class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(CategoryRepository $category): Response
    {
        return $this->render(
            'category/index.html.twig',
            ['category' => $category->findAll()]
        );
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        // Create a new Category Object
        $category = new Category();
        // Create the associated Form
        $form = $this->createForm(CategoryType::class, $category);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            // Deal with the submitted data
            // Get the Entity Manager
            $entityManager = $doctrine->getManager();
            // Persist Category Object
            $entityManager->persist($category);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to categories list
            return $this->redirectToRoute('category_index');
        }
        // Render the form
        return $this->render('category/new.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @Route("/{categoryName}", methods={"GET"}, name="show")
     */
    public function show(CategoryRepository $category, string $categoryName, ProgramRepository $programs): Response
    {
        $cat = $category->findOneBy(
            ['name' => $categoryName]
        );

        if (!$cat) {
            throw $this->createNotFoundException(
                'No category with name ' . $categoryName . ' found in category\'s table.'
            );
        };

        $prog = $programs->findBy(
            ['category' => $cat->getId()],
            ['id' => 'DESC'],
            3
        );

        return $this->render(
            'category/show.html.twig',
            ['programs' => $prog, 'category' => $cat]
        );
    }
}
