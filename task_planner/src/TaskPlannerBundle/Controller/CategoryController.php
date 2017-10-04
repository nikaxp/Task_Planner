<?php

namespace TaskPlannerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use TaskPlannerBundle\Entity\Category;
use TaskPlannerBundle\Form\CategoryType;
use Symfony\Component\Form\Form;

/**
 * Class TaskController
 * @Route("/category")
 */

class CategoryController extends Controller
{

    /**
     * @Route("/new", name = "createCategory")
     * @Method("GET")
     */
    public function newCategoryFormAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category, array(
            'action' => $this->generateUrl('newCategory')
        ));
        $form->handleRequest($request);

        return $this->render('TaskPlannerBundle:Category:new.html.twig', array(
            'form' => $form->createView()
        ));
    }
    /**
     * @Route("/new", name = "newCategory")
     * @Method("POST")
     */
    public function newCategoryAction(Request $request)
    {
        $category = new Category();
        $user = $this->getUser();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $category = $form->getData();
            $category->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('showCategory', array(
                'id' => $category->getId()
            ));
        }

        return new Response("Incorrect data. Try create Person again.");


    }

    /**
     * @Route("/", name = "showAllCategories")
     */
    public function showAllCategoriesAction()
    {
        $user = $this->getUser()->getId();
        $repo = $this->getDoctrine()->getRepository('TaskPlannerBundle:Category');
        $categories = $repo->findBy(['user' => $user]);

        return $this->render('TaskPlannerBundle:Category:showAll.html.twig', array(
            'categories' => $categories
        ));
    }

    /**
     * @Route("/{id}", name="showCategory", requirements = {"id" = "\d+"})
     */
    public function showCategoryAction($id)
    {
        $repo = $this->getDoctrine()->getRepository('TaskPlannerBundle:Category');
        $category = $repo->find($id);

        if($category) {

            return $this->render('TaskPlannerBundle:Category:show.html.twig', array(
                'category' => $category,
            ));

        }

        return new Response("Category not found");
    }


    /**
     * @Route("/{id}/edit" , name = "editFormCategory")
     * @Method("GET")
     */
    public function editFormAction(Request $request, $id)
    {

        $repo = $this->getDoctrine()->getRepository('TaskPlannerBundle:Category');
        $category = $repo->find($id);

        if($category) {
            $form = $this->createForm(CategoryType::class, $category, array(
                'action' => $this->generateUrl('editCategory', array('id' => $id))
            ));

            $form->handleRequest($request);


        return $this->render('TaskPlannerBundle:Category:edit.html.twig', array(
            'form' => $form->createView(),
            'category' => $category
        ));

        }

        return new Response("Category not found");
    }



    /**
     * @Route("/{id}/edit", name = "editCategory")
     * @Method("POST")
     */
    public function editCategoryAction(Request $request, $id)
    {
        $repo = $this->getDoctrine()->getRepository('TaskPlannerBundle:Category');
        $category = $repo->find($id);

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $category = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('editCategory', array(
                'id'=>$category->getId()
            ));
        }

        return new Response("Incorrect data. Try edit category again.");

    }

    /**
     * @Route("/{id}/delete", name = "deleteCategory")
     */
    public function deleteCategoryAction($id)
    {
        $repo = $this->getDoctrine()->getRepository('TaskPlannerBundle:Category');
        $category = $repo->find($id);

        if($category) {
            $nameOfCategory = $category->getName();

            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();

            return $this->render('TaskPlannerBundle:Category:delete.html.twig', array(
                'nameOfCategory' => $nameOfCategory
            ));
        }

        return new Response("Category not found");

    }


}
