<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoryController extends Controller
{
    /**
     * @Route("/categories", name="category_list")
     */
    public function indexAction(Request $request)
    {
        $categories = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();

        // Render Template
        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/category/create", name="category_create")
     */
    public function createAction(Request $request)
    {
        $category = new Category;

        $form = $this->createFormBuilder($category)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control mb-3')))
            ->add('save', SubmitType::class, array('label' => 'Create Category', 'attr' => array('class' => 'btn btn-primary')))
            ->getForm();

        // Handle Request
        $form->handleRequest($request);

        // Check Submit and validity
        if($form->isSubmitted() && $form->isValid()) {
            $name = $form['name']->getData();

            // Get Current Date and Time
            $now = new \DateTime('now');

            $category->setName($name);
            $category->setCreateDate($now);

            $em = $this->getDoctrine()->getManager();

            $em->persist($category);
            $em->flush();

            $this->addFlash(
                'notice',
                'Category Saved'
            );

            return $this->redirectToRoute('category_list');
        }

        // Render Template
        return $this->render('category/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/category/edit/{id}", name="category_edit")
     */
    public function editAction($id, Request $request)
    {
        $category = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->find($id);

        if(!$category){
            throw $this->createNotFoundException(
                'No category found for id '.$id
            );
            
        }

        $category->setName($category->getName());

        $form = $this->createFormBuilder($category)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control mb-3')))
            ->add('save', SubmitType::class, array('label' => 'Update Category', 'attr' => array('class' => 'btn btn-primary')))
            ->getForm();

        // Handle Request
        $form->handleRequest($request);

        // Check Submit and validity
        if($form->isSubmitted() && $form->isValid()) {
            $name = $form['name']->getData();

            

            $em = $this->getDoctrine()->getManager();
            $category = $em->getRepository('AppBundle:Category')->find($id);

            $category->setName($name);
            $em->flush();

            $this->addFlash(
                'notice',
                'Category Updated'
            );

            return $this->redirectToRoute('category_list');
        }

        // Render Template
        return $this->render('category/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/category/delete/{id}", name="category_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AppBundle:Category')->find($id);

        if(!$category) {
            throw $this->createNotFoundException(
                'No category found with id of '.$id 
            );
        }

        $em->remove($category);
        $em->flush();

        $this->addFlash(
            'notice',
            'Category deleted'
        );

        return $this->redirectToRoute('category_list');
       
    }
}