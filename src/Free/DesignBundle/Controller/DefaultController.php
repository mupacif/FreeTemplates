<?php
namespace Free\DesignBundle\Controller;

        use Symfony\Component\HttpFoundation\Request;

            use Symfony\Bundle\FrameworkBundle\Controller\Controller;
            use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

            use Symfony\Component\Form\Extension\Core\Type\TextType;
            use Symfony\Component\Form\Extension\Core\Type\TextareaType;
            use Symfony\Component\Form\Extension\Core\Type\FormType;
            use Symfony\Component\Form\Extension\Core\Type\SubmitType;
            use Symfony\Bridge\Doctrine\Form\Type\EntityType;

            use Free\DesignBundle\Entity\Category;
            use Free\DesignBundle\Entity\Template;


            class DefaultController extends Controller
            {
                /**
                 * @Route("/")
                 */
                public function indexAction()
                {
                    return $this->render('FreeDesignBundle:Default:index.html.twig');
                }


                    public function addTemplateAction(Request $request)
                {
                        // On crée un objet Advert
                $template = new Template();

                // On crée le FormBuilder grâce au service form factory
                $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $template);

                // On ajoute les champs de l'entité que l'on veut à notre formulaire
                $formBuilder
                  ->add('uri',      TextType::class)
                  ->add('title',    TextType::class)
                  ->add('info',    TextareaType::class)
                  ->add('categories', EntityType::class, array(
                    'class' => 'FreeDesignBundle:Category',
                    'choice_label' => 'name',
                    'multiple' => false,
                    'expanded' => false
                ))
                  ->add('save',      SubmitType::class)
                ;
                       $form = $formBuilder->getForm();
                // Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard
                   if ($request->isMethod('POST')) {
                    // On fait le lien Requête <-> Formulaire
                    // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
                    $form->handleRequest($request);

                    // On vérifie que les valeurs entrées sont correctes
                    // (Nous verrons la validation des objets en détail dans le prochain chapitre)
                    if ($form->isValid()) {
                        $save = $this->getDoctrine()->getManager();
                        $save->persist($template);
                        $save->flush();
                        //return new Response("GGG ");

                        return $this->redirectToRoute('free_design_page');
                    }
                }
                // À partir du formBuilder, on génère le formulaire
         
                    return $this->render('FreeDesignBundle:Default:add.html.twig',["title"=>"Template","form" => $form->createView()]);
                }

            
                public function addCategoryAction(Request $request)
                {
                        // On crée un objet Advert
                $cat= new Category();

                // On crée le FormBuilder grâce au service form factory
                $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $cat);

                // On ajoute les champs de l'entité que l'on veut à notre formulaire
                $formBuilder
                  ->add('name',      TextType::class)
                  ->add('save',      SubmitType::class)
                ;
                       $form = $formBuilder->getForm();
                // Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard
                   if ($request->isMethod('POST')) {
                    // On fait le lien Requête <-> Formulaire
                    // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
                    $form->handleRequest($request);

                    // On vérifie que les valeurs entrées sont correctes
                    // (Nous verrons la validation des objets en détail dans le prochain chapitre)
                    if ($form->isValid()) {
                        $save = $this->getDoctrine()->getManager();
                        $save->persist($cat);
                        $save->flush();
                        //return new Response("GGG ");

                        return $this->redirectToRoute('free_design_page');
                    }
                }
                // À partir du formBuilder, on génère le formulaire
         
                    return $this->render('FreeDesignBundle:Default:add.html.twig',["title"=>"category","form" => $form->createView()]);
                }



            }
