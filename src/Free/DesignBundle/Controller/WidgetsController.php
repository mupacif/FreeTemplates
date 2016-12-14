<?php
namespace Free\DesignBundle\Controller;

        use Symfony\Bundle\FrameworkBundle\Controller\Controller;

        class WidgetsController extends Controller
            {
            	                   public function categoriesAction()
                            {
                             $repository = $this
                            ->getDoctrine()
                            ->getManager()
                            ->getRepository('FreeDesignBundle:Category');

                             $categories= $repository->findAll();
                                return $this->render(
                            'FreeDesignBundle:widgets:showCategories.html.twig',
                             array('categories' => $categories)
                             );

                            }
            }