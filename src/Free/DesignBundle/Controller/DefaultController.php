<?php
namespace Free\DesignBundle\Controller;

                     use Symfony\Component\HttpFoundation\Request;


                    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
                    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
                    use Symfony\Component\HttpFoundation\BinaryFileResponse;
                    use Symfony\Component\HttpFoundation\ResponseHeaderBag;


                    use Symfony\Component\Form\Extension\Core\Type\TextType;
                    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
                    use Symfony\Component\Form\Extension\Core\Type\FormType;
                    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
                    use Symfony\Component\Form\Extension\Core\Type\FileType;
                    use Free\DesignBundle\FileUploader;
                    use Symfony\Bridge\Doctrine\Form\Type\EntityType;

                    use Free\DesignBundle\Entity\Category;
                    use Free\DesignBundle\Entity\Template;


                    class DefaultController extends Controller
                    {
                        /**
                         * @Route("/")
                         */   

                         public function topMenuAction($name=null)
                        {
                         $repository = $this
                        ->getDoctrine()
                        ->getManager()
                        ->getRepository('FreeDesignBundle:Category');

                         $categories= $repository->findAll();
                            return $this->render(
                        'Free/DesignBundle/Default/nav.html.twig',
                     array('categories' => $categories)
                         );

                        }
                               public function downloadTemplateAction($name)
                        {
                             $name = str_replace("-", " ", $name);
                             $repository = $this
                        ->getDoctrine()
                        ->getManager()
                        ->getRepository('FreeDesignBundle:Template')        ;

                         $template= $repository->findOneByTitle($name);
                         
                             if(count($template))
                                {

                                    $title = $template->getTitle();
                                    $files = $template->getFiles();
                                    $path= 'templates/'.$files.'/'.str_replace(" ", "-", $title).'.zip';
                      
                                    $response = new BinaryFileResponse($path);
                                    $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

                                    return $response;
                                }
                                else
                                    throw $this->createNotFoundException('Cant download this template');
                     
                        }


                                public function showTemplateAction($name)
                        {
                             $name = str_replace("-", " ", $name);
                             $repository = $this
                        ->getDoctrine()
                        ->getManager()
                        ->getRepository('FreeDesignBundle:Template')        ;

                         $template= $repository->findOneByTitle($name);
                       //  var_dump($template);
                       if(count($template))
                           return $this->render('Free/DesignBundle/Default/show.html.twig',['template' =>  $template]);
                      else
                             return $this->redirectToRoute('free_design_page');
                        }


                        public function previewAction($name)
                        {
                             $name = str_replace("-", " ", $name);
                             $repository = $this
                        ->getDoctrine()
                        ->getManager()
                        ->getRepository('FreeDesignBundle:Template')        ;

                         $template= $repository->findOneByTitle($name);
                       //  var_dump($template);
                       if(count($template))
                           return $this->render('Free/DesignBundle/Default/preview.html.twig',['template' =>  $template]);
                      else
                             return $this->redirectToRoute('free_design_page');
                        }

                          public function indexAction($category=null)
                        {
                             $repository = $this
                              ->getDoctrine()
                              ->getManager()
                              ->getRepository('FreeDesignBundle:Template');

                              if(empty($category))
                              {
                                 $listTemplates = $repository->findAll();
                              }
                              else
                              {
    
                                 $listTemplates = $repository->getTemplatesWithCategories(array($category));
                              }


                            return $this->render('Free/DesignBundle/Default/index.html.twig',['templates' => $listTemplates]);
                        }

                            public function addTemplateAction(Request $request)
                        {
                                // On crée un objet Advert
                        $template = new Template();

                        // On crée le FormBuilder grâce au service form factory
                        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $template);

                        // On ajoute les champs de l'entité que l'on veut à notre formulaire
                        $formBuilder
                           ->add('title',    TextType::class)
                           ->add('info',    TextareaType::class)
                           ->add('tumbnail', FileType::class, array('label' => 'Add Tumbnail image :'))
                           ->add('files',FileType::class , array('label' => 'Add zip files :'))
                           ->add('categories', EntityType::class, array(
                            'class' => 'FreeDesignBundle:Category',
                            'choice_label' => 'name',
                            'multiple' => true,
                            'expanded' => true
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
                                 $file = $template->getTumbnail();

                                $folderName= md5(uniqid());
                             $fileName = md5(uniqid()).'.'.$file->guessExtension();
                                $file->move(
                    $this->getParameter('templates_directory').'/'.$folderName,
                    $fileName
                );

                                 $name = str_replace(" ", "-", $template->getTitle());

                                $files=$template->getFiles();
                           
                                $zip = new \ZipArchive;
                                echo $files->getClientOriginalExtension()=='zip';
  $files->move( $this->getParameter('templates_directory').'/'.$folderName
                    ,
                   $name.'.zip'
                );
                                echo $files->getRealPath();

                                if ($zip->open($this->getParameter('templates_directory').'/'.$folderName.'/'.$name.'.zip')) {

                                             
        $zip->extractTo($this->getParameter('templates_directory').'/'.$folderName.'/preview');
        $zip->close();
        echo 'ok';
    } else {
        echo 'échec';
    }
    echo $folderName;



                               $template->setTumbnail($fileName);
                                $template->setFiles($folderName);
                                $save = $this->getDoctrine()->getManager();
                                $save->persist($template);
                                $save->flush();
                            

                             return $this->redirectToRoute('free_design_page');
                            }
                        }
                        // À partir du formBuilder, on génère le formulaire
                 
                            return $this->render('Free/DesignBundle/Default/add.html.twig',["title"=>"Template","form" => $form->createView()]);
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
                 
                            return $this->render('Free/DesignBundle/Default/add.html.twig',["title"=>"category","form" => $form->createView()]);
                        }







                    }
