<?php
namespace Free\DesignBundle\Controller;

        use Symfony\Bundle\FrameworkBundle\Controller\Controller;
        use Symfony\Component\HttpFoundation\JsonResponse;
        use Symfony\Component\HttpFoundation\Request;
        use Free\DesignBundle\Entity\Category;

        class APIController extends Controller
        {
    

                        public function addCategoryAction(Request $request)
                        {
                                // On crée un objet Advert
                        $cat= new Category();
                                 $response = new JsonResponse();
                                   $response->setData(array(
                                            'data' => 0
                                        ));
                
                              $name=$request->get('name');
                        // Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard
                           if ($request->isMethod('POST') && !empty($name)) {
                            

                                $name=$request->get('name');
                                $cat = new Category();
                                $cat->setName($name);

                                $save = $this->getDoctrine()->getManager();
                                $save->persist($cat);
                                $save->flush();

                      
                                        $response->setData(array(
                                            'data' => 1
                                        ));
                            }
                            return $response;
                        }

                          public function deleteCategoryAction(Request $request)
                        {
                      
                                        // On crée un objet Advert
                        $cat= new Category();
                                 $response = new JsonResponse();
                                   $response->setData(array(
                                            'data' => 0
                                        ));
                
                            
                        // Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard
                                    $id=$request->get('id');
                     
                           if ($request->isMethod('POST') && !empty($id)) {
                            

                    


                        

                                $save = $this->getDoctrine()->getManager();
                                $cat = $save->getRepository('FreeDesignBundle:Category')->find($id);


                                if (!$cat) {
                                    throw $this->createNotFoundException('No category found for id '.$id);
                                }
                                $save->remove($cat);
                                $save->flush();

                      
                                        $response->setData(array(
                                            'data' => 1
                                        ));
                            }
                            return $response;

                        }
        }