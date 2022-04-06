<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
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
     * @Route("/{categoryName}", methods={"GET"}, name="show")
     */
    public function show(CategoryRepository $category, string $categoryName, ProgramRepository $programs): Response
    {
        $cat = $category->findOneBy(
            ['name' => $categoryName]
        );
       
        if (!$cat) {
            throw $this->createNotFoundException(
                'No category with name '.$categoryName.' found in category\'s table.'
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